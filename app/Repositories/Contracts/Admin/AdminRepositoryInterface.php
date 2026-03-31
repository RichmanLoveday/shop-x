<?php

namespace App\Repositories\Contracts\Admin;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
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

    public function createUser(string $name, string $email, string $password): Admin;

    public function assignRole(Admin $admin, Role $role): void;

    public function allRoleUsers(int $currentAdminId): LengthAwarePaginator;

    public function getRoleUser(int $id): ?Admin;

    public function deleteUser(Admin $admin): bool;
}
