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
        if (app()->runningInConsole() && !app()->runningUnitTests()) {
            return Setting::query()
                ->pluck('value', 'key')
                ->toArray();
        }

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
        $data['site_currency_icon'] = $this->findCurrencySymbol($data['site_currency']);
        $this->settingsRepo->update($data);

        // Clear old cache
        $this->forgetCache();

        // Refresh cache and config
        $this->setSettings();
    }

    public function addPaymentSettings(array $settings): void
    {
        $this->settingsRepo->update($settings);

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

    public function currencies(): array
    {
        return config('currencies');
    }

    public function countries(): array
    {
        return config('countries');
    }

    public function findCurrencySymbol(string $currencyCode): string
    {
        $symbols = config('currencies-icons');
        return $symbols[$currencyCode] ?? '';
    }
}