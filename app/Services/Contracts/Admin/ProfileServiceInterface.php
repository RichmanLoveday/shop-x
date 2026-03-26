<?php

namespace App\Services\Contracts\Admin;

use App\Models\Admin;

interface ProfileServiceInterface
{
    public function updateProfile(array $data): Admin;

    public function changePassword(array $data): bool;

    public function uploadAvatar(Admin $user, $image): string;
}
