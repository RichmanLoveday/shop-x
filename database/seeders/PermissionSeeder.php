<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            // Access management
            'Access Management' => [
                'view-role',
                'create-role',
                'edit-role',
                'delete-role',
                'view-admin-user',
                'create-user',
                'edit-user',
                'delete-user',
                'resend-user-mail',
            ],
            // KYC management
            'KYC Management' => [
                'view-kyc',
                'edit-kyc',
                // 'under-review-kyc',
                // 'approve-kyc',
                // 'reject-kyc',
            ],
        ];

        foreach ($permissions as $group_name => $permission) {
            foreach ($permission as $perm) {
                Permission::create(['name' => $perm, 'group_name' => $group_name, 'guard_name' => 'admin']);
            }
        }
    }
}
