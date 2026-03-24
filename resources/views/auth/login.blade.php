{{-- <x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
                    name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                    href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}



@extends('frontend.layout.app')

@section('contents')
    <x-frontend.breadcrumb :items="[['url' => '/', 'label' => 'Home'], ['url' => route('login'), 'label' => 'Login']]" />

    <div class="page-content pt-150 pb-135">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 col-lg-10 col-md-12 m-auto">
                    <div class="row">

                        <!-- Left Image -->
                        <div class="col-lg-6 pr-30 d-none d-lg-block">
                            <img class="border-radius-15" src="{{ asset('assets/frontend/imgs/page/login-1.png') }}"
                                alt="Login" />
                        </div>

                        <!-- Login Form -->
                        <div class="col-lg-6 col-md-8">
                            <x-auth-session-status class="mb-4" :status="session('status')" />
                            <x-auth-session-status class="mb-4" :status="session('error')" />

                            <div class="login_wrap widget-taber-content background-white">
                                <div class="padding_eight_all bg-white">

                                    <div class="heading_s1">
                                        <h1 class="mb-5">Login</h1>
                                        <p class="mb-30">Don't have an account?
                                            <a href="{{ route('register') }}">Create here</a>
                                        </p>
                                    </div>

                                    <!-- Google Login -->
                                    <div class="mb-4">
                                        <a href="{{ route('google.redirect') }}"
                                            class="btn btn-default w-100 d-flex align-items-center justify-content-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path
                                                    d="M20.945 11a9 9 0 1 1 -3.284 -5.997l-2.655 2.392a5.5 5.5 0 1 0 2.119 6.605h-4.125v-3h7.945">
                                                </path>
                                            </svg>
                                            Log in with Google
                                        </a>
                                    </div>

                                    <div class="text-center my-4">
                                        <span class="px-3 bg-white text-muted">OR</span>
                                        <hr class="mt-2">
                                    </div>

                                    <!-- Login Form -->
                                    <form id="loginForm" method="POST" action="{{ route('login') }}">
                                        @csrf

                                        <div class="form-group">
                                            <input type="email" class="form-control" name="email"
                                                placeholder="Username or Email *" value="{{ old('email') }}" required />
                                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                        </div>

                                        <div class="form-group">
                                            <input type="password" class="form-control" name="password"
                                                placeholder="Your password *" required />
                                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                        </div>

                                        <!-- hCaptcha -->
                                        <div class="form-group mt-4">
                                            <div id="hcaptcha" class="h-captcha"
                                                data-sitekey="{{ config('services.captcha.sitekey') }}"></div>

                                            <div id="captcha-error" class="text-danger mt-2" style="display: none;">
                                                Please complete the security verification
                                            </div>

                                            <x-input-error :messages="$errors->get('h-captcha-response')" class="mt-2" />
                                        </div>

                                        <div class="login_footer form-group mb-50 mt-4">
                                            <div class="chek-form">
                                                <div class="custome-checkbox">
                                                    <input class="form-check-input" type="checkbox" name="remember"
                                                        id="remember" />
                                                    <label class="form-check-label" for="remember">
                                                        <span>Remember me</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <a class="text-muted" href="{{ route('password.request') }}">Forgot
                                                password?</a>
                                        </div>

                                        <div class="form-group">
                                            <button type="submit" id="loginBtn"
                                                class="btn btn-heading btn-block hover-up">
                                                Log in
                                            </button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://js.hcaptcha.com/1/api.js" async defer></script>

        <script>
            $(document).ready(function() {
                const form = $('#loginForm');
                const loginBtn = $('#loginBtn');
                const captchaError = $('#captcha-error');

                console.log(captchaError);

                form.on('submit', function(e) {
                    const response = hcaptcha.getResponse();
                    captchaError.show();

                    if (response.length === 0) {
                        e.preventDefault(); // Stop form submission
                        captchaError.show(); // Show error message
                        return false;
                    } else {
                        captchaError.hide(); // Hide error if captcha is solved
                    }
                });

                // Optional: Reset error when user starts solving captcha
                window.onHcaptchaVerify = function() {
                    captchaError.hide();
                };
            });
        </script>
    @endpush
@endsection
