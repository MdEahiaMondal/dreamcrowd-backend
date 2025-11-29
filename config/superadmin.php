<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Top Super Admin Email
    |--------------------------------------------------------------------------
    |
    | This is the email address of the top-level super administrator.
    | This user will have unrestricted access to all admin functions and
    | cannot be deleted, banned, or have their role changed by any other admin.
    |
    | IMPORTANT: Set this in your .env file using SUPER_ADMIN_EMAIL
    |
    */
    'email' => env('SUPER_ADMIN_EMAIL', 'admin@dreamcrowd.com'),

    /*
    |--------------------------------------------------------------------------
    | Top Super Admin Protection
    |--------------------------------------------------------------------------
    |
    | These settings control the protection level for the top super admin.
    |
    */
    'protection' => [
        // Prevent deletion of top super admin account
        'prevent_delete' => true,

        // Prevent banning of top super admin account
        'prevent_ban' => true,

        // Prevent role change of top super admin
        'prevent_role_change' => true,

        // Bypass all permission checks for top super admin
        'bypass_permissions' => true,

        // Hide from admin management list (optional - set to false to show)
        'hide_from_list' => false,
    ],
];
