<?php

namespace App\Services\Admin;

use App\Repositories\Contracts\Admin\AdminRepositoryInterface;
use App\Services\Contracts\Admin\RoleServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleService implements RoleServiceInterface
{
    public function __construct(
        protected AdminRepositoryInterface $adminRepo
    ) {}

    public function getAllRole(): Role|Collection
    {
        return $this->adminRepo->getRoles();
    }

    public function getSingleRole(int $id, string $guardName = 'admin'): ?Role
    {
        return $this->adminRepo->getRole($id, $guardName);
    }

    public function getPermissions(): Permission|Collection
    {
        return $this->adminRepo->getPermissions();
    }

    public function addNewRole(array $data, string $guardName = 'admin'): ?Role
    {
        $name = $data['name'] ?? null;
        $permissions = $data['permissions'] ?? [];
        return $this->adminRepo->createRole($name, $permissions, $guardName);
    }

    public function updateRole(int $roleId, array $data): ?Role
    {
        // check if role exists
        $role = $this->adminRepo->getRole($roleId);

        if (!$role)
            throw new \Exception('Role not found');

        $name = $data['name'] ?? null;
        $permissions = $data['permissions'] ?? [];

        return $this->adminRepo->updateRole($role, $name, $permissions);
    }

    public function deleteRole(int $roleId): bool
    {
        $role = $this->adminRepo->getRole($roleId);

        if (!$role) {
            throw new \Exception('Role not found');
        }

        return $this->adminRepo->deleteRole($role);
    }
}
