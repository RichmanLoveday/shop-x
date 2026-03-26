<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\Contracts\User\Auth\HcaptchaServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function __construct(
        private HcaptchaServiceInterface $hcaptchaService
    ) {}

    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // dd($request->all());
        $request->authenticate();

        // verify hcaptcha security
        if (!$this->hcaptchaService->verify($request->input('h-captcha-response'))) {
            return redirect()->back()->with('error', 'Invalid hCaptcha response.');
        }

        $request->session()->regenerate();

        // dd(auth('web')->user()->isVendor());
        // if role is vendor, redirect to vendor dashboard
        if (auth('web')->user()->isVendor())
            return redirect()->route('vendor.dashboard');

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
