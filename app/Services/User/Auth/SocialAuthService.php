<?php

namespace App\Services\User\Auth;

use App\Models\User;
use App\Repositories\Contracts\User\Auth\UserAuthRepositoryInterface;
use App\Services\Contracts\User\Auth\SocialAuthServiceInterface;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class SocialAuthService implements SocialAuthServiceInterface
{
    public function __construct(
        protected UserAuthRepositoryInterface $userRepository
    ) {}

    public function handleGoogleCallback(): User
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            // dd($googleUser->getId(), $googleUser->getName(), $googleUser->getEmail(), $googleUser->getAvatar());
        } catch (Exception $e) {
            logger()->error('Google authentication failed', ['error' => $e->getMessage()]);
            throw new Exception('Google authentication failed: ' . $e->getMessage());
        }

        // check for the current user google id provider
        $user = $this->userRepository->findByProvider('google', $googleUser->getId());

        // dd($user);

        if (!$user) {
            // check by user email
            $user = $this->userRepository->findByEmail($googleUser->getEmail());

            if (!$user) {
                // / links to existing user account
                $user = $this->userRepository->createFromSocial([
                    'provider' => 'google',
                    'provider_id' => $googleUser->getId(),
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'avatar' => $googleUser->getAvatar() ?? asset('assets/avatar.png'),
                ]);

                // dd($user);
            } else {
                $user = $this->userRepository->updateOrCreateFromSocial(
                    'google',
                    $googleUser->getId(),
                    [
                        'name' => $googleUser->getName(),
                        'email' => $googleUser->getEmail(),
                        'avatar' => $googleUser->getAvatar() ?? asset('assets/avatar.png'),
                    ]
                );
            }
        }

        return $user;
    }

    public function checkIfUserLoggedInWithProvider(string $email): User|bool
    {

        $user = $this->userRepository->findByEmail($email);

        if ($user && !is_null($user->provider)) {
            return $user;
        }

        return false;
    }
}