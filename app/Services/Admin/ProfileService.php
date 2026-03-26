<?php

namespace App\Services\Admin;

use App\Models\Admin;
use App\Repositories\Contracts\Admin\AdminRepositoryInterface;
use App\Services\Contracts\Admin\ProfileServiceInterface;
use Illuminate\Support\Facades\DB;

class ProfileService implements ProfileServiceInterface
{
    public function __construct(
        protected AdminRepositoryInterface $adminRepository,
        protected Admin $admin,
    ) {
        // register the admin guard in the constructor
        $this->admin = auth('admin')->user();
    }

    /*
     * Update admin profile
     *
     * @param array $data
     * @return User
     */
    public function updateProfile(array $data): Admin
    {
        return $this->adminRepository->updateProfile($this->admin, $data);
    }

    /**
     * Upload avatar with DB transaction
     */
    public function uploadAvatar(Admin $admin, $image): string
    {
        $admin = $this->admin;
        // dd($admin);

        return DB::transaction(function () use ($admin, $image) {
            // dd($admin);
            // remove old avatar
            $admin->clearMediaCollection('avatar');

            // upload new avatar (Spatie)
            $media = $admin
                ->addMedia($image)
                ->usingFileName(uniqid() . '.' . $image->getClientOriginalExtension())
                ->toMediaCollection('avatar');

            // store avatar path in DB
            $admin->avatar = $media->getUrl();
            $admin->save();

            return $admin->avatar;
        });
    }

    /*
     * Change admin password
     *
     * @param array $data
     * @return bool
     */
    public function changePassword(array $data): bool
    {
        // dd($data);
        $currentPassword = $data['current_password'] ?? '';
        $newPassword = $data['password'] ?? '';
        return $this->adminRepository->changePassword($this->admin, $currentPassword, $newPassword);
    }
}