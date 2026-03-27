<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\KycCreateRequest;
use App\Services\Contracts\Vendor\KycServiceInterface;
use App\Traits\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KycController extends Controller
{
    use Alert;

    public function __construct(
        protected KycServiceInterface $kycService
    ) {}

    public function index()
    {
        // redirect to dashboard if kyc is pending or approved
        $vendorKyc = $this->kycService->getCurrentVendorKyc();
        if ($vendorKyc && $vendorKyc->canNotBeEditable()) {
            return redirect()->route('vendor.dashboard');
        }

        return view('frontend.pages.kyc');
    }

    public function store(KycCreateRequest $request)
    {
        // dd($request->all());

        try {
            $this->kycService->addVendorKyc($request->all());
            $this->created('Your KYC has been submitted successfully! Please wait for admin approval.');

            return redirect()->route('vendor.dashboard');
        } catch (\Exception $e) {
            logger()->error('Failed to upload kyc documents: ' . $e->getMessage());
            $this->failed('An error occur while uploading kyc verification');

            return redirect()->back();
        }
    }
}
