<?php

namespace App\Services\Contracts\User\Auth;

use App\Models\User;

interface SocialAuthServiceInterface
{
    public function handleGoogleCallback(): User;
}