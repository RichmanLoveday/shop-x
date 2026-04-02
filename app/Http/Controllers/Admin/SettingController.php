<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GeneralSettingsRequestUpdate;
use App\Services\Contracts\Admin\SettingsServiceInterface;
use App\Traits\Alert;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    use Alert;

    public function __construct(
        protected SettingsServiceInterface $settingsService
    ) {}

    public function index()
    {
        $generalSettings = (object) [
            'site_name' => $this->settingsService->getSetting('site_name'),
            'site_email' => $this->settingsService->getSetting('site_email'),
            'site_phone' => $this->settingsService->getSetting('site_phone'),
        ];

        return view('admin.settings.sections.general-settings', compact('generalSettings'));
    }


    public function generalSettings(GeneralSettingsRequestUpdate $request)
    {
        $this->settingsService->addSetting($request->validated());

        $this->updated('General Settings updated successfully');

        return redirect()->back();
    }
}
