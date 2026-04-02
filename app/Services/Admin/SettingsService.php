<?php

namespace App\Services\Admin;

use App\Models\Setting;
use App\Repositories\Contracts\Admin\SettingsRepositoryInterface;
use App\Services\Contracts\Admin\SettingsServiceInterface;
use Illuminate\Support\Facades\Cache;

class SettingsService implements SettingsServiceInterface
{
    protected $cacheKey = 'app_settings';

    public function __construct(
        protected SettingsRepositoryInterface $settingsRepo
    ) {}

    public function getSettings(): array
    {
        return Cache::rememberForever($this->cacheKey, function () {
            return Setting::query()
                ->pluck('value', 'key')
                ->toArray();
        });
    }

    public function setSettings(): void
    {
        $settings = $this->getSettings();
        config()->set('settings', $settings);
    }

    public function forgetCache(): void
    {
        Cache::forget($this->cacheKey);
    }

    public function addSetting(array $data): void
    {
        $this->settingsRepo->update($data);

        // Clear old cache
        $this->forgetCache();

        // Refresh cache and config
        $this->setSettings();
    }

    public function getSetting(string $key, string $default = null): mixed
    {
        $settings = $this->getSettings();
        return $settings[$key] ?? $default;
    }
}
