<?php

namespace App\Repositories\Eloquent\Admin;

use App\Models\Admin;
use App\Repositories\Contracts\Admin\AdminRepositoryInterface;
use Illuminate\Support\Facades\Hash;

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
}
