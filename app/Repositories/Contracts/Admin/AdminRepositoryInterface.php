<?php

namespace App\Repositories\Contracts\Admin;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

interface AdminRepositoryInterface
{
    public function updateProfile(Admin $user, array $data): Admin;

    public function changePassword(Admin $user, string $currentPassword, string $newPassword): bool;

    public function getRoles(): Role|Collection;

    public function getRole(int $id, string $guardName = 'admin'): ?Role;

    public function getPermissions(): Permission|Collection;

    public function createRole(string $role, array $permissions, string $guardName = 'admin'): Role;

    public function updateRole(Role $role, string $name, array $permissions): Role;

    public function deleteRole(Role $role): bool;
}
