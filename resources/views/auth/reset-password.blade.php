@extends('frontend.layout.app')

@section('contents')
    <x-frontend.breadcrumb :items="[['url' => '/', 'label' => 'Home'], ['url' => route('login'), 'label' => 'Reset Password']]" />

    <div class="page-content pt-150 pb-140">
        <div class="container">
            <div class="row">
                <div class="col-xl-5 col-lg-6 col-md-12 m-auto">
                    <div class="login_wrap widget-taber-content background-white">
                        <x-auth-session-status class="mb-4" :status="session('status')" />

                        <div class="padding_eight_all bg-white">
                            <div class="heading_s1">
                                <img class="border-radius-15"
                                    src="{{ asset('frontend/assets/imgs/page/forgot_password.svg') }}" alt="" />
                                <h2 class="mb-15 mt-15">Reset Password</h2>
                                {{-- <p class="mb-30">Not to worry, we got you! Let’s get you a new password. Please
                                    enter your email address.</p> --}}
                            </div>
                            <form method="post" action="{{ route('password.store') }}" id="loginForm">
                                @csrf
                                <input type="hidden" name="token" value="{{ $request->route('token') }}">
                                <input type="hidden" name="email" value="{{ old('email', $request->email) }}" />
                                <div class="form-group">
                                    <input type="email" name="email" value="{{ old('email', $request->email) }}"
                                        placeholder="Email *" disabled />
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>


                                <div class="form-group">
                                    <input type="password" required="" name="password" placeholder="Password *" />
                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                </div>

                                <div class="form-group">
                                    <input type="password" required="" name="password_confirmation"
                                        placeholder="Confirm Password *" />
                                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                </div>

                                <!-- hCaptcha -->
                                <div class="form-group mt-4">
                                    <div id="hcaptcha" class="h-captcha"
                                        data-sitekey="{{ config('services.captcha.sitekey') }}">
                                    </div>

                                    <div id="captcha-error" class="text-danger mt-2" style="display: none;">
                                        Please complete the security verification
                                    </div>

                                    <x-input-error :messages="$errors->get('h-captcha-response')" class="mt-2" />
                                </div>
                                {{-- <div class="login_footer form-group mb-50">
                                    <div class="chek-form">
                                        <div class="custome-checkbox">
                                            <input class="form-check-input" type="checkbox" name="checkbox"
                                                id="exampleCheckbox1" value="" />
                                            <label class="form-check-label" for="exampleCheckbox1"><span>I agree to
                                                    terms & Policy.</span></label>
                                        </div>
                                    </div>
                                    <a class="text-muted" href="#">Learn more</a>
                                </div> --}}
                                <div class="form-group">
                                    <button type="submit" class="btn btn-heading btn-block hover-up" name="login">Reset
                                        password</button>
                                </div>
                            </form>
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
