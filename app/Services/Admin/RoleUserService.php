<?php

namespace App\Services\Admin;

use App\Models\Admin;
use App\Repositories\Contracts\Admin\AdminRepositoryInterface;
use App\Services\Contracts\Admin\RoleUserServiceInterface;
use App\Services\MailService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class RoleUserService implements RoleUserServiceInterface
{
    public function __construct(
        protected AdminRepositoryInterface $adminRepo,
    ) {}

    public function getAllRoleUsers(): LengthAwarePaginator
    {
        return $this->adminRepo->allRoleUsers(auth('admin')->user()->id);
    }

    public function getUser(int $id): ?Admin
    {
        return $this->adminRepo->getRoleUser($id);
    }

    public function addNewRoleUser(array $data): Admin
    {
        // dd($data);
        // check if role exists
        $roleId = $data['role_id'] ?? null;
        $name = $data['name'] ?? null;
        $email = $data['email'] ?? null;
        $password = $data['password'] ?? null;

        $role = $this->adminRepo->getRole($roleId);
        if (!$role) {
            throw new \Exception('Role not found');
        }

        // prevent assignment of super admin role
        if ($role->name == 'super_admin') {
            throw new \Exception('You cannot create a user with super admin role');
        }

        // create user
        $admin = $this->adminRepo->createUser($name, $email, $password);

        // assign role to user
        $this->assignRole($admin, $role);

        // send email to user with credentials
        MailService::sendNewAdminMail($name, $email, $password);

        // return admin user
        return $admin->fresh();
    }

    public function updateExistingUser(int $id, array $data): ?Admin
    {
        $adminTablePayload['email'] = $data['email'];
        $adminTablePayload['name'] = $data['name'];

        // check if admin user is found
        $admin = $this->adminRepo->getRoleUser($id);

        if (!$admin) {
            throw new \Exception('Admin user not found');
        }

        // prevent assigning super admin role
        if ($admin->hasRole('super_admin')) {
            throw new \Exception('You cannot modify a super admin account');
        }

        // update admin user
        $admin = $this->adminRepo->updateProfile($admin, $adminTablePayload);

        // assign new role if role_id is provided
        if ($admin && isset($data['role_id'])) {
            $role = $this->adminRepo->getRole($data['role_id']);

            if (!$role) {
                throw new \Exception('Role not found');
            }

            // prevent assignment of super admin role
            if ($role->name == 'super_admin') {
                throw new \Exception('You cannot assign super admin role');
            }

            $this->assignRole($admin, $role);
        }

        return $admin->fresh();
    }

    public function deleteUser(int $id): bool
    {
        $admin = $this->adminRepo->getRoleUser($id);

        if (!$admin) {
            throw new \Exception('Admin user not found');
        }

        if ($admin->hasRole('super_admin')) {
            throw new \Exception('You can not delete super admin');
        }

        return $this->adminRepo->deleteUser($admin);
    }

    private function assignRole(Admin $admin, Role $role): void
    {
        $this->adminRepo->assignRole($admin, $role);
    }

    public function resendMail(int $id): void
    {
        $admin = $this->adminRepo->getRoleUser($id);
        if (!$admin) {
            throw new \Exception('Admin user not found');
        }

        $newPassword = Str::random(10);
        $this->adminRepo->changePassword($admin, $admin->password, $newPassword);

        // send email to user with credentials
        MailService::sendNewAdminMail($admin->name, $admin->email, $newPassword);
    }
}