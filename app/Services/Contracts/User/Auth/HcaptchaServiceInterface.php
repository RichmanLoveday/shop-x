<?php

namespace App\Services\Contracts\User\Auth;

interface HcaptchaServiceInterface
{
    public function verify(string $token): bool;
}
