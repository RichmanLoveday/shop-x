<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\Contracts\User\ProfileServiceInterface;
use App\Traits\Alert;
use Illuminate\Http\Request;

use function Laravel\Prompts\notify;

class ProfileController extends Controller
{
    use Alert;

    public function __construct(
        protected ProfileServiceInterface $profileService
    ) {}

    public function index()
    {
        return view('frontend.dashboard.account-details.index');
    }

    public function update(Request $request)
    {
        // dd($request->all());

        // validate the request data
        $request->validate([
            'name' => 'required|string|max:50',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            // 'email' => 'required|email|unique:users,email,' . auth('web')->user()->id,
        ]);

        try {
            $this->profileService->updateProfile([
                'name' => $request->name,
            ]);

            // check if image file exist
            if ($request->hasFile('avatar')) {
                $user = auth('web')->user();
                $this->profileService->uploadAvatar($user, $request->file('avatar'));
            }

            $this->created('Profile updated successfully');

            return redirect()->back();
        } catch (\Exception $e) {
            logger()->error('Failed to update profile',
                ['error' => $e->getMessage()]);

            return redirect()->back()->with('error', 'Failed to update profile: ' . $e->getMessage());
        }
    }

    public function changePassword(Request $request)
    {
        // validate the request data
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);

        try {
            if (!$this->profileService->changePassword($request->all())) {
                $this->failed('Current password is incorrect');
                return redirect()->back();
            }

            $this->updated('Password changed successfully');

            return redirect()->back();
        } catch (\Exception $e) {
            logger()->error('Failed to change password',
                ['error' => $e->getMessage()]);

            $this->failed('Failed to change password');

            return redirect()->back();
        }
    }
}
