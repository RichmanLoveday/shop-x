<?php

namespace App\Services\Contracts;

interface PaymentSettingsServiceInterface
{
    public function getPaystackSettings(): array;
    public function getFlutterwaveSettings(): array;
    public function getStripeSettings(): array;
    public function paymentCountries(): array;
    public function addPaymentSettings(array $settings): void;
}
