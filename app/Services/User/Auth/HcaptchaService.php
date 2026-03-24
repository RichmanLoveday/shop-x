<?php

namespace App\Services\User\Auth;

use App\Services\Contracts\User\Auth\HcaptchaServiceInterface;
use Illuminate\Support\Facades\Http;

class HcaptchaService implements HcaptchaServiceInterface
{
    protected string $hCaptchaSecret;

    public function __construct()
    {
        $this->hCaptchaSecret = config('services.captcha.secret');
    }

    public function verify(string $token): bool
    {
        if (!$token) return false;

        $verify = Http::asForm()->post('https://hcaptcha.com/siteverify', [
            'secret'   => $this->hCaptchaSecret,
            'response' => $token,
        ]);


        $verification = $verify->json();

        // check if verification is passed
        if (!$verification['success']) {
            $errorMessage = $verification['error-codes'][0] ?? 'Captcha verification failed';

            // log warning data
            logger()->warning("hCaptcha verification failed", [
                "token" => $token,
                "error" => $errorMessage,
            ]);

            return false;
        }


        return true;
    }
}
