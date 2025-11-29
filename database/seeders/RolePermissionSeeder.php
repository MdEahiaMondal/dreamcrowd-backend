<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Define all permissions grouped by category
        $permissions = [
            // User Management
            'users.view' => 'View users list',
            'users.view_details' => 'View user details',
            'users.create' => 'Create new users',
            'users.edit' => 'Edit user information',
            'users.delete' => 'Delete users',
            'users.ban' => 'Ban/unban users',
            'users.export' => 'Export users data',

            // Order Management
            'orders.view' => 'View orders list',
            'orders.view_details' => 'View order details',
            'orders.edit' => 'Edit order information',
            'orders.cancel' => 'Cancel orders',
            'orders.refund' => 'Process refunds',
            'orders.export' => 'Export orders data',

            // Financial Management
            'finances.view_transactions' => 'View transactions',
            'finances.view_payouts' => 'View payouts',
            'finances.process_payouts' => 'Process seller payouts',
            'finances.manage_commissions' => 'Manage commission settings',
            'finances.view_reports' => 'View financial reports',
            'finances.export' => 'Export financial data',

            // Content Management
            'content.manage_categories' => 'Manage categories',
            'content.manage_services' => 'Manage services/gigs',
            'content.manage_reviews' => 'Manage reviews',
            'content.manage_disputes' => 'Manage disputes',
            'content.manage_coupons' => 'Manage coupons',

            // Admin Management (Most Sensitive)
            'admins.view' => 'View admins list',
            'admins.create' => 'Create new admins',
            'admins.edit' => 'Edit admin information',
            'admins.delete' => 'Delete admins',
            'admins.assign_roles' => 'Assign roles to admins',
            'admins.view_activity' => 'View admin activity logs',

            // Settings Management
            'settings.site_settings' => 'Manage site settings',
            'settings.email_templates' => 'Manage email templates',
            'settings.payment_settings' => 'Manage payment settings',
            'settings.zoom_settings' => 'Manage Zoom settings',
        ];

        // Create all permissions
        foreach ($permissions as $name => $description) {
            Permission::firstOrCreate(
                ['name' => $name],
                ['guard_name' => 'web']
            );
        }

        // Define roles with hierarchy levels (lower = higher authority)
        $roles = [
            [
                'name' => 'super_admin',
                'hierarchy_level' => 1,
                'permissions' => Permission::all() // All permissions
            ],
            [
                'name' => 'moderator',
                'hierarchy_level' => 2,
                'permissions' => [
                    'users.*',
                    'orders.*',
                    'content.*',
                    'settings.site_settings',
                    'settings.email_templates',
                ]
            ],
            [
                'name' => 'support',
                'hierarchy_level' => 3,
                'permissions' => [
                    'users.view',
                    'users.view_details',
                    'users.ban',
                    'orders.view',
                    'orders.view_details',
                    'orders.cancel',
                    'content.manage_disputes',
                    'content.manage_reviews',
                ]
            ],
            [
                'name' => 'finance',
                'hierarchy_level' => 4,
                'permissions' => [
                    'finances.*',
                    'orders.view',
                    'orders.view_details',
                    'orders.refund',
                    'users.view',
                    'users.view_details',
                ]
            ],
        ];

        // Create roles and assign permissions
        foreach ($roles as $roleData) {
            $role = Role::firstOrCreate(
                ['name' => $roleData['name']],
                [
                    'guard_name' => 'web',
                    'hierarchy_level' => $roleData['hierarchy_level']
                ]
            );

            // Update hierarchy_level if role already exists
            if ($role->hierarchy_level !== $roleData['hierarchy_level']) {
                $role->update(['hierarchy_level' => $roleData['hierarchy_level']]);
            }

            // Assign permissions
            if ($roleData['permissions'] instanceof \Illuminate\Database\Eloquent\Collection) {
                // All permissions
                $role->syncPermissions($roleData['permissions']);
            } else {
                // Wildcard permissions (e.g., 'users.*')
                $permissionsToAssign = [];
                foreach ($roleData['permissions'] as $permPattern) {
                    if (str_ends_with($permPattern, '.*')) {
                        // Wildcard: get all permissions starting with the prefix
                        $prefix = str_replace('.*', '', $permPattern);
                        $matchingPerms = Permission::where('name', 'LIKE', $prefix . '.%')->pluck('name')->toArray();
                        $permissionsToAssign = array_merge($permissionsToAssign, $matchingPerms);
                    } else {
                        // Exact permission name
                        $permissionsToAssign[] = $permPattern;
                    }
                }
                $role->syncPermissions(array_unique($permissionsToAssign));
            }
        }

        $this->command->info('Roles and permissions created successfully!');
        $this->command->info('Created ' . Permission::count() . ' permissions');
        $this->command->info('Created ' . Role::count() . ' roles');
    }
}
