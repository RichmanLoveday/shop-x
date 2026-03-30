<?php

namespace App\Services\Contracts\Admin;

use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

interface RoleServiceInterface
{
    public function getPermissions(): Permission|Collection;

    public function getAllRole(): Role|Collection;

    public function getSingleRole(int $id, string $guardName = 'admin'): ?Role;

    public function addNewRole(array $data, string $guardName = 'admin'): ?Role;

    public function updateRole(int $roleId, array $data): ?Role;

    public function deleteRole(int $roleId): bool;
}
