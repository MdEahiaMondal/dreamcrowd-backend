<?php

namespace App\Services;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminManagementService
{
    protected $activityService;

    public function __construct(AdminActivityService $activityService)
    {
        $this->activityService = $activityService;
    }

    /**
     * Get all admins with pagination and filters
     */
    public function getAllAdmins($filters = [])
    {
        $query = User::with('roles')
            ->adminsOnly()
            ->withCount(['adminActivities', 'targetedAdminActivities']);

        // Apply role filter
        if (!empty($filters['role'])) {
            $query->whereHas('roles', function($q) use ($filters) {
                $q->where('name', $filters['role']);
            });
        }

        // Apply search filter
        if (!empty($filters['search'])) {
            $query->where(function($q) use ($filters) {
                $q->where('first_name', 'LIKE', "%{$filters['search']}%")
                  ->orWhere('last_name', 'LIKE', "%{$filters['search']}%")
                  ->orWhere('email', 'LIKE', "%{$filters['search']}%")
                  ->orWhere('id', 'LIKE', "%{$filters['search']}%");
            });
        }

        // Apply date range filter
        if (!empty($filters['date_from'])) {
            $query->whereDate('created_at', '>=', $filters['date_from']);
        }
        if (!empty($filters['date_to'])) {
            $query->whereDate('created_at', '<=', $filters['date_to']);
        }

        // Sorting
        if (!empty($filters['sort'])) {
            switch ($filters['sort']) {
                case 'name_asc':
                    $query->orderBy('first_name', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('first_name', 'desc');
                    break;
                case 'date_asc':
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'date_desc':
                default:
                    $query->orderBy('created_at', 'desc');
                    break;
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        return $query->paginate($filters['per_page'] ?? 20);
    }

    /**
     * Create a new admin
     */
    public function createAdmin(array $data, User $createdBy)
    {
        DB::beginTransaction();
        try {
            // Validate role hierarchy
            $role = Role::where('name', $data['role'])->first();
            if (!$role) {
                throw new \Exception('Invalid role specified');
            }

            // Check if creator can assign this role
            if (!$createdBy->isTopSuperAdmin()) {
                $creatorRole = $createdBy->roles()->first();
                if (!$creatorRole || $creatorRole->hierarchy_level >= $role->hierarchy_level) {
                    throw new \Exception('You cannot create an admin with equal or higher authority than yourself');
                }
            }

            // Create the admin user
            $admin = User::create([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => 2, // Admin role
                'admin_role' => 2,
                'is_admin' => true,
                'is_active' => true,
                'email_verify' => 1,
            ]);

            // Assign role
            $admin->assignRole($role);

            // Log activity
            $this->activityService->log(
                admin: $createdBy,
                activityType: 'admin_created',
                description: "Created admin: {$admin->first_name} {$admin->last_name} ({$admin->email}) with role: {$role->name}",
                targetAdmin: $admin,
                metadata: [
                    'admin_id' => $admin->id,
                    'role' => $role->name,
                ]
            );

            DB::commit();
            return $admin;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Update admin information
     */
    public function updateAdmin(User $admin, array $data, User $updatedBy)
    {
        // Prevent updating top super admin
        if ($admin->isTopSuperAdmin() && config('superadmin.protection.prevent_role_change', true)) {
            throw new \Exception('Cannot update the top super admin');
        }

        // Check hierarchy
        if (!$updatedBy->canManageAdmin($admin)) {
            throw new \Exception('You do not have permission to update this admin');
        }

        DB::beginTransaction();
        try {
            $oldData = [
                'first_name' => $admin->first_name,
                'last_name' => $admin->last_name,
                'email' => $admin->email,
                'role' => $admin->roles()->first()?->name,
            ];

            // Update basic info
            $admin->update([
                'first_name' => $data['first_name'] ?? $admin->first_name,
                'last_name' => $data['last_name'] ?? $admin->last_name,
                'email' => $data['email'] ?? $admin->email,
            ]);

            // Update password if provided
            if (!empty($data['password'])) {
                $admin->update(['password' => Hash::make($data['password'])]);
            }

            // Update role if changed
            if (!empty($data['role']) && $data['role'] !== $oldData['role']) {
                $newRole = Role::where('name', $data['role'])->first();

                if (!$updatedBy->isTopSuperAdmin()) {
                    $updaterRole = $updatedBy->roles()->first();
                    if (!$updaterRole || $updaterRole->hierarchy_level >= $newRole->hierarchy_level) {
                        throw new \Exception('You cannot assign a role with equal or higher authority than yourself');
                    }
                }

                $admin->syncRoles([$newRole]);
            }

            // Log activity
            $this->activityService->log(
                admin: $updatedBy,
                activityType: 'admin_updated',
                description: "Updated admin: {$admin->first_name} {$admin->last_name} ({$admin->email})",
                targetAdmin: $admin,
                metadata: [
                    'admin_id' => $admin->id,
                    'old_data' => $oldData,
                    'new_data' => [
                        'first_name' => $admin->first_name,
                        'last_name' => $admin->last_name,
                        'email' => $admin->email,
                        'role' => $admin->roles()->first()?->name,
                    ],
                ]
            );

            DB::commit();
            return $admin->fresh('roles');
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Delete (soft delete) an admin
     */
    public function deleteAdmin(User $admin, User $deletedBy)
    {
        // Prevent deleting top super admin
        if ($admin->isTopSuperAdmin() && config('superadmin.protection.prevent_delete', true)) {
            throw new \Exception('Cannot delete the top super admin');
        }

        // Check hierarchy
        if (!$deletedBy->canManageAdmin($admin)) {
            throw new \Exception('You do not have permission to delete this admin');
        }

        DB::beginTransaction();
        try {
            $adminData = [
                'id' => $admin->id,
                'name' => $admin->first_name . ' ' . $admin->last_name,
                'email' => $admin->email,
                'role' => $admin->roles()->first()?->name,
            ];

            $admin->delete(); // Soft delete

            // Log activity
            $this->activityService->log(
                admin: $deletedBy,
                activityType: 'admin_deleted',
                description: "Deleted admin: {$adminData['name']} ({$adminData['email']})",
                targetAdmin: null,
                metadata: ['deleted_admin' => $adminData]
            );

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Restore a soft-deleted admin
     */
    public function restoreAdmin($adminId, User $restoredBy)
    {
        $admin = User::withTrashed()->find($adminId);

        if (!$admin) {
            throw new \Exception('Admin not found');
        }

        if (!$admin->trashed()) {
            throw new \Exception('Admin is not deleted');
        }

        DB::beginTransaction();
        try {
            $admin->restore();

            // Log activity
            $this->activityService->log(
                admin: $restoredBy,
                activityType: 'admin_restored',
                description: "Restored admin: {$admin->first_name} {$admin->last_name} ({$admin->email})",
                targetAdmin: $admin,
                metadata: ['admin_id' => $admin->id]
            );

            DB::commit();
            return $admin;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Change admin role
     */
    public function changeRole(User $admin, string $newRoleName, User $changedBy)
    {
        // Prevent changing top super admin role
        if ($admin->isTopSuperAdmin() && config('superadmin.protection.prevent_role_change', true)) {
            throw new \Exception('Cannot change the role of the top super admin');
        }

        // Check hierarchy
        if (!$changedBy->canManageAdmin($admin)) {
            throw new \Exception('You do not have permission to change this admin\'s role');
        }

        $newRole = Role::where('name', $newRoleName)->first();
        if (!$newRole) {
            throw new \Exception('Invalid role specified');
        }

        // Validate hierarchy for role assignment
        if (!$changedBy->isTopSuperAdmin()) {
            $changerRole = $changedBy->roles()->first();
            if (!$changerRole || $changerRole->hierarchy_level >= $newRole->hierarchy_level) {
                throw new \Exception('You cannot assign a role with equal or higher authority than yourself');
            }
        }

        DB::beginTransaction();
        try {
            $oldRole = $admin->roles()->first();
            $admin->syncRoles([$newRole]);

            // Log activity
            $this->activityService->log(
                admin: $changedBy,
                activityType: 'role_changed',
                description: "Changed role of {$admin->first_name} {$admin->last_name} from {$oldRole?->name} to {$newRole->name}",
                targetAdmin: $admin,
                metadata: [
                    'admin_id' => $admin->id,
                    'old_role' => $oldRole?->name,
                    'new_role' => $newRole->name,
                ]
            );

            DB::commit();
            return $admin->fresh('roles');
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Get admin statistics
     */
    public function getAdminStats()
    {
        return [
            'total_admins' => User::adminsOnly()->count(),
            'super_admins' => User::adminsOnly()->whereHas('roles', function($q) {
                $q->where('name', 'super_admin');
            })->count(),
            'moderators' => User::adminsOnly()->whereHas('roles', function($q) {
                $q->where('name', 'moderator');
            })->count(),
            'support' => User::adminsOnly()->whereHas('roles', function($q) {
                $q->where('name', 'support');
            })->count(),
            'finance' => User::adminsOnly()->whereHas('roles', function($q) {
                $q->where('name', 'finance');
            })->count(),
            'recent_activities_count' => \App\Models\AdminActivity::where('created_at', '>=', now()->subDays(7))->count(),
        ];
    }
}
