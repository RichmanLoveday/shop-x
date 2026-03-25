<?php

namespace App\Services\User;

use App\Models\User;
use App\Repositories\Contracts\User\Auth\UserAuthRepositoryInterface;
use App\Services\Contracts\User\ProfileServiceInterface;
use Illuminate\Support\Facades\DB;

class ProfileService implements ProfileServiceInterface
{
    public function __construct(
        protected UserAuthRepositoryInterface $userRepository
    ) {}

    /*
     * Update user profile
     *
     * @param array $data
     * @return User
     */
    public function updateProfile(array $data): User
    {
        $user = auth('web')->user();
        return $this->userRepository->updateProfile($user, $data);
    }

    /**
     * Upload avatar with DB transaction
     */
    public function uploadAvatar(User $user, $image): string
    {
        // $user = auth('web')->user();

        return DB::transaction(function () use ($user, $image) {
            // remove old avatar
            $user->clearMediaCollection('avatar');

            // upload new avatar (Spatie)
            $media = $user
                ->addMedia($image)
                ->usingFileName(uniqid() . '.' . $image->getClientOriginalExtension())
                ->toMediaCollection('avatar');

            // store avatar path in DB
            $user->avatar = $media->getUrl();
            $user->save();

            return $user->avatar;
        });
    }

    /*
     * Change user password
     *
     * @param array $data
     * @return bool
     */
    public function changePassword(array $data): bool
    {
        // dd($data);
        $user = auth('web')->user();
        $currentPassword = $data['current_password'] ?? '';
        $newPassword = $data['password'] ?? '';
        return $this->userRepository->changePassword($user, $currentPassword, $newPassword);
    }
}
