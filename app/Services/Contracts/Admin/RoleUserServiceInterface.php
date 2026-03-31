<?php

namespace App\Services\Contracts\Admin;

use App\Models\Admin;
use Illuminate\Pagination\LengthAwarePaginator;

interface RoleUserServiceInterface
{
    public function getAllRoleUsers(): LengthAwarePaginator;

    public function addNewRoleUser(array $data): Admin;

    public function getUser(int $id): ?Admin;

    public function updateExistingUser(int $id, array $data): ?Admin;

    public function resendMail(int $id): void;

    public function deleteUser(int $id): bool;
}
