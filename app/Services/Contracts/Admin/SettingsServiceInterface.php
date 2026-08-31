<?php

namespace App\Services\Contracts\Admin;

use App\Models\Setting;

interface SettingsServiceInterface
{
    public function getSettings(): array;

    public function getSetting(string $key, string $default = null): mixed;

    public function setSettings(): void;

    public function addSetting(array $data): void;

    public function forgetCache(): void;

    public function currencies(): array;

    public function countries(): array;

    public function findCurrencySymbol(string $currencyCode): string;

    public function addPaymentSettings(array $settings): void;
}
