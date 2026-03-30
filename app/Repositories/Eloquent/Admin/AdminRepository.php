<?php

namespace App\Repositories\Eloquent\Admin;

use App\Models\Admin;
use App\Repositories\Contracts\Admin\AdminRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Termwind\Components\Dd;

class AdminRepository implements AdminRepositoryInterface
{
    public function updateProfile(Admin $user, array $data): Admin
    {
        $user->fill($data);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return $user;
    }

    public function changePassword(Admin $user, string $currentPassword, string $newPassword): bool
    {
        // dd($currentPassword, $newPassword);
        if (!password_verify($currentPassword, Hash::make($newPassword)))
            return false;

        $user->password = bcrypt($newPassword);
        $user->save();

        return true;
    }

    public function getPermissions(): Permission|Collection
    {
        return Permission::all()->groupBy('group_name');
    }

    public function getRoles(): Role|Collection
    {
        return Role::withCount('permissions')->get();
    }

    public function getRole(int $id, string $guardName = 'admin'): ?Role
    {
        return Role::where('id', $id)
            ->where('guard_name', $guardName)
            ->first();
    }

    public function createRole(string $name, array $permissions, string $guardName = 'admin'): Role
    {
        $role = Role::create(['name' => $name, 'guard_name' => $guardName]);

        $permissionModels = Permission::whereIn('id', $permissions)
            ->get();

        $role->syncPermissions($permissionModels);

        return $role;
    }

    public function updateRole(Role $role, string $name, array $permissions): Role
    {
        $role->update(['name' => $name]);
        $permissionModels = Permission::whereIn('id', $permissions)
            ->get();

        $role->syncPermissions($permissionModels);

        return $role;
    }

    public function deleteRole(Role $role): bool
    {
        return DB::transaction(function () use ($role) {
            $role->users()->detach();
            $role->permissions()->detach();
            $role->delete();

            return true;
        });
    }
}
