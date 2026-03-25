<?php

namespace App\Services\Contracts\User;

use App\Models\User;

interface ProfileServiceInterface
{
    public function updateProfile(array $data): User;

    public function changePassword(array $data): bool;

    public function uploadAvatar(User $user, $image): string;
}
