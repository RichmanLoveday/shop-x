@extends('frontend.layout.app')

@section('contents')
    <x-frontend.breadcrumb :items="[['url' => '/', 'label' => 'Home'], ['url' => route('login'), 'label' => 'Register']]" />
    <div class="page-content pt-150 pb-140">
        <div class="container">
            <div class="row">
                <div class="col-xxl-8 col-xl-10 col-lg-12 col-md-9 m-auto">
                    <div class="row align-items-center justify-content-center">
                        <div class="col-md-8">
                            <div class="login_wrap widget-taber-content background-white">
                                <div class="padding_eight_all bg-white">
                                    <div class="heading_s1">
                                        <h2 class="mb-5">Create an Account</h2>
                                        <p class="mb-30">Already have an account? <a href="{{ route('login') }}">Login</a>
                                        </p>
                                    </div>

                                    <div class="mb-3">
                                        <a href="{{ route('google.redirect') }}" class="btn btn-default w-100">
                                            <svg class="icon icon-tabler" xmlns="http://www.w3.org/2000/svg" width="24"
                                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path
                                                    d="M20.945 11a9 9 0 1 1 -3.284 -5.997l-2.655 2.392a5.5 5.5 0 1 0 2.119 6.605h-4.125v-3h7.945">
                                                </path>
                                            </svg> Sign up with Google
                                        </a>
                                    </div>

                                    <div class="text-center my-4">
                                        <span class="px-3 bg-white text-muted">OR</span>
                                        <hr class="mt-2">
                                    </div>

                                    <form method="post" action="{{ route('register') }}">
                                        @csrf
                                        <div class="form-group">
                                            <input type="text" required="" value="{{ old('name') }}" name="name"
                                                placeholder="Name" />
                                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                        </div>

                                        <div class="form-group">
                                            <input type="text" required="" value="{{ old('email') }}" name="email"
                                                placeholder="Email" />
                                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                        </div>

                                        <div class="form-group">
                                            <input required="" type="password" name="password" placeholder="Password" />
                                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                        </div>
                                        <div class="form-group">
                                            <input required="" type="password" name="password_confirmation"
                                                placeholder="Confirm password" />
                                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
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

                                        <div class="payment_option mb-30">
                                            <div class="custome-radio">
                                                <input class="form-check-input" required="" type="radio"
                                                    name="payment_option" id="exampleRadios3" checked="" />
                                                <label class="form-check-label" for="exampleRadios3"
                                                    data-bs-toggle="collapse" data-target="#bankTranfer"
                                                    aria-controls="bankTranfer">I am a customer</label>
                                            </div>
                                            <div class="custome-radio">
                                                <input class="form-check-input" required="" type="radio"
                                                    name="payment_option" id="exampleRadios4" checked="" />
                                                <label class="form-check-label" for="exampleRadios4"
                                                    data-bs-toggle="collapse" data-target="#checkPayment"
                                                    aria-controls="checkPayment">I am a vendor</label>
                                            </div>
                                        </div>
                                        <div class="form-group mb-0">
                                            <button type="submit"
                                                class="btn btn-fill-out btn-block hover-up font-weight-bold"
                                                name="login">Submit &amp; Register</button>
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
