<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Contracts\User\Auth\HcaptchaServiceInterface;
use App\Traits\Alert;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    use Alert;

    public function __construct(
        private HcaptchaServiceInterface $hcaptchaService
    ) {}

    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // dd($request->all());
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', new Enum(UserRole::class)],
        ]);

        // verify hcaptcha security
        if (!$this->hcaptchaService->verify($request->input('h-captcha-response'))) {
            $this->failed('Invalid hCaptcha response');
            return redirect()->back();
        }

        $userRole = UserRole::from($request->role)->value;
        // dd($userRole);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'avatar' => asset('assets/defaults/avatar.png'),
            'role' => $userRole,
        ]);

        event(new Registered($user));

        Auth::login($user);

        $this->created('Account created successfully!');

        // if role is vendor, redirect to vendor dashboard
        if (auth('web')->user()->isVendor())
            return redirect(route('vendor.dashboard', absolute: false));

        return redirect(route('dashboard', absolute: false));
    }
}
