<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Contracts\User\Auth\SocialAuthServiceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    public function __construct(
        protected SocialAuthServiceInterface $socialAuthService,
    ) {}


    public function redirectToGoogle() {
        return Socialite::driver('google')->redirect();
    }


    public function handleGoogleCallback() {
        try {
            $user = $this->socialAuthService->handleGoogleCallback();

            Auth::guard('web')->login($user, true);

            return redirect()->intended(route('dashboard', absolute: false))
                ->with('success', 'Successfully logged in with Google!');

        } catch (\Exception $e) {
            logger()->error('Error during Google authentication callback', ['error' => $e->getMessage()]);
            return redirect()->route('login')
                ->with('error', 'Something went wrong. Please try again.');
        }
    }
}
