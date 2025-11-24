<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class TopSuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the top super admin email from config (fallback to default if not set)
        $topSuperAdminEmail = config('superadmin.email', 'admin@dreamcrowd.com');

        // Check if user already exists
        $superAdmin = User::where('email', $topSuperAdminEmail)->first();

        if (!$superAdmin) {
            // Create the top super admin user
            $superAdmin = User::create([
                'first_name' => 'Super',
                'last_name' => 'Admin',
                'email' => $topSuperAdminEmail,
                'password' => Hash::make('password'), // Change this in production!
                'email_verify' => 'verified',
                'role' => 2, // Admin role
                'admin_role' => 2, // Admin role
                'is_admin' => true,
                'is_active' => true,
            ]);

            $this->command->info("Top Super Admin created: {$topSuperAdminEmail}");
            $this->command->warn('Default password is "password" - CHANGE THIS IMMEDIATELY!');
        } else {
            $this->command->info("Top Super Admin already exists: {$topSuperAdminEmail}");
        }

        // Ensure super_admin role exists
        $superAdminRole = Role::where('name', 'super_admin')->first();

        if ($superAdminRole) {
            // Assign super_admin role if not already assigned
            if (!$superAdmin->hasRole('super_admin')) {
                $superAdmin->assignRole('super_admin');
                $this->command->info('Super Admin role assigned to top super admin');
            }
        } else {
            $this->command->warn('super_admin role does not exist. Run RolePermissionSeeder first!');
        }

        // Mark as admin
        if (!$superAdmin->is_admin) {
            $superAdmin->update(['is_admin' => true]);
        }
    }
}
