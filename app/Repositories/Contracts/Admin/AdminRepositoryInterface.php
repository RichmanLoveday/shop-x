<?php

namespace App\Repositories\Contracts\Admin;

use App\Models\Admin;

interface AdminRepositoryInterface
{
    public function updateProfile(Admin $user, array $data): Admin;

    public function changePassword(Admin $user, string $currentPassword, string $newPassword): bool;
}
