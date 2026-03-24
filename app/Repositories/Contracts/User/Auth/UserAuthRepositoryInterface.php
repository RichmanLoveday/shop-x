<?php

namespace App\Repositories\Contracts\User\Auth;

use App\Models\User;

interface UserAuthRepositoryInterface
{
    public function findByEmail(string $email): ?User;

    public function findByProvider(string $provider, string $providerId): ?User;

    public function createFromSocial(array $data): User;

    public function updateOrCreateFromSocial(string $provider, string $providerId, array $data): User;
}
