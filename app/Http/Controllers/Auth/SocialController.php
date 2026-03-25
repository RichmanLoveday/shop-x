<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Contracts\User\Auth\SocialAuthServiceInterface;
use App\Traits\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    use Alert;

    public function __construct(
        protected SocialAuthServiceInterface $socialAuthService,
    ) {}

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $user = $this->socialAuthService->handleGoogleCallback();

            Auth::guard('web')->login($user, true);

            $this->created('Successfully, logged in!');

            return redirect()
                ->intended(route('dashboard', absolute: false));
        } catch (\Exception $e) {
            logger()->error('Error during Google authentication callback', ['error' => $e->getMessage()]);

            $this->failed('Something went wrong during Google authentication. Please try again.');

            return redirect()
                ->route('login');
        }
    }
}
