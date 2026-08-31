<?php

namespace App\Services;

use App\Services\Contracts\Admin\SettingsServiceInterface;
use App\Services\Contracts\PaymentSettingsServiceInterface;

class PaymentSettingsService implements PaymentSettingsServiceInterface
{
    public function __construct(
        protected SettingsServiceInterface $settingsService
    ) {}

    public function getPaystackSettings(): array
    {
        return [
            'paystack_status' => $this->settingsService->getSetting('paystack_status'),
            'paystack_mode' => $this->settingsService->getSetting('paystack_mode'),
            'paystack_country' => $this->settingsService->getSetting('paystack_country'),
            'paystack_currency_icon' => $this->settingsService->getSetting('paystack_currency_icon'),
            'paystack_currency_rate' => $this->settingsService->getSetting('paystack_currency_rate'),
            'paystack_public_key' => $this->settingsService->getSetting('paystack_public_key'),
            'paystack_secret_key' => $this->settingsService->getSetting('paystack_secret_key'),
            'paystack_webhook_url' => $this->settingsService->getSetting('paystack_webhook_url'),
        ];
    }

    public function addPaymentSettings(array $settings): void
    {
        $this->settingsService->addPaymentSettings($settings);
    }

    public function getFlutterwaveSettings(): array
    {
        return [
            'flutterwave_status' => $this->settingsService->getSetting('flutterwave_status'),
            'flutterwave_mode' => $this->settingsService->getSetting('flutterwave_mode'),
            'flutterwave_country' => $this->settingsService->getSetting('flutterwave_country'),
            'flutterwave_currency_icon' => $this->settingsService->getSetting('flutterwave_currency_icon'),
            'flutterwave_currency_rate' => $this->settingsService->getSetting('flutterwave_currency_rate'),
            'flutterwave_public_key' => $this->settingsService->getSetting('flutterwave_public_key'),
            'flutterwave_secret_key' => $this->settingsService->getSetting('flutterwave_secret_key'),
            'flutterwave_encryption_key' => $this->settingsService->getSetting('flutterwave_encryption_key'),
            'flutterwave_webhook_url' => $this->settingsService->getSetting('flutterwave_webhook_url'),
        ];
    }

    public function getStripeSettings(): array
    {
        return [
            'stripe_status' => $this->settingsService->getSetting('stripe_status'),
            'stripe_mode' => $this->settingsService->getSetting('stripe_mode'),
            'stripe_country' => $this->settingsService->getSetting('stripe_country'),
            'stripe_currency_icon' => $this->settingsService->getSetting('stripe_currency_icon'),
            'stripe_currency_rate' => $this->settingsService->getSetting('stripe_currency_rate'),
            'stripe_publishable_key' => $this->settingsService->getSetting('stripe_publishable_key'),
            'stripe_secret_key' => $this->settingsService->getSetting('stripe_secret_key'),
            'stripe_webhook_secret' => $this->settingsService->getSetting('stripe_webhook_secret'),
        ];
    }

    public function paymentCountries(): array
    {
        return config('payment-countries');
    }
}
