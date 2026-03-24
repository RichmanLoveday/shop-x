<?php

namespace App\Repositories\Eloquent\User\Auth;

use App\Models\User;
use App\Repositories\Contracts\User\Auth\UserAuthRepositoryInterface;

class UserAuthRepository implements UserAuthRepositoryInterface
{

   public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    public function findByProvider(string $provider, string $providerId): ?User
    {
        return User::where('provider', $provider)
                   ->where('provider_id', $providerId)
                   ->first();
    }

    public function createFromSocial(array $data): User
    {
        // dd($data);
        return User::create([
            'name'            => $data['name'],
            'email'           => $data['email'],
            'provider'        => $data['provider'],
            'provider_id'     => $data['provider_id'],
            //'avatar'          => $data['avatar'] ?? null,
            'email_verified_at' => now(),
            'password'        => bcrypt(uniqid()), // random password for social users
        ]);
    }

    public function updateOrCreateFromSocial(string $provider, string $providerId, array $data): User
    {
        return User::updateOrCreate(
            [
                'provider'    => $provider,
                'provider_id' => $providerId,
            ],
            [
                'name'              => $data['name'],
                'email'             => $data['email'],
                // 'avatar'            => $data['avatar'] ?? null,
                'email_verified_at' => now(),
            ]
        );
    }
}