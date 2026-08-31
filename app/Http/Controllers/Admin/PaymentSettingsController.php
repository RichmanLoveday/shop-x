<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FlutterwaveSettingRequestUpdate;
use App\Http\Requests\Admin\PaystackSettingRequestUpdate;
use App\Services\Contracts\Admin\SettingsServiceInterface;
use App\Services\Contracts\PaymentSettingsServiceInterface;
use App\Traits\Alert;
use Illuminate\Http\Request;

class PaymentSettingsController extends Controller
{
    use Alert;

    public function __construct(
        protected PaymentSettingsServiceInterface $paymentSettingsService,
        protected SettingsServiceInterface $settingsService,
    ) {}

    public function index()
    {
        return view('admin.payment-settings.index');
    }

    public function stripeSettings()
    {
        $stripeSettings = (object) $this->paymentSettingsService->getStripeSettings();
        $countries = $this->paymentSettingsService->paymentCountries();
        // dd($countries);
        $currencies = $this->settingsService->currencies();
        return view('admin.payment-settings.sections.stripe', compact('countries', 'currencies', 'stripeSettings'));
    }

    public function updateStripeSettings(Request $request)
    {
        dd($request->all());
        $this->paymentSettingsService->addPaymentSettings($request->all());

        $this->updated('Stripe settings updated successfully');

        return redirect()->back();
    }

    public function flutterwaveSettings()
    {
        $flutterwaveSettings = (object) $this->paymentSettingsService->getFlutterwaveSettings();
        $countries = $this->paymentSettingsService->paymentCountries();
        $currencies = $this->settingsService->currencies();
        return view('admin.payment-settings.sections.flutterwave', compact('countries', 'currencies', 'flutterwaveSettings'));
    }

    public function updateFlutterwaveSettings(FlutterwaveSettingRequestUpdate $request)
    {
        // dd($request->all());
        $this->paymentSettingsService->addPaymentSettings($request->all());

        $this->updated('Flutterwave settings updated successfully');

        return redirect()->back();
    }

    public function paystackSettings()
    {
        $paystackSettings = (object) $this->paymentSettingsService->getPaystackSettings();

        // dd($paystackSettings);
        $countries = $this->paymentSettingsService->paymentCountries();
        $currencies = $this->settingsService->currencies();
        return view('admin.payment-settings.sections.paystack', compact('countries', 'currencies', 'paystackSettings'));
    }


    public function updatePaystackSettings(PaystackSettingRequestUpdate $request)
    {
        dd($request->all());
        $this->paymentSettingsService->addPaymentSettings($request->all());

        $this->updated('Paystack settings updated successfully');

        return redirect()->back();
    }
}
