<?php

namespace App\Http\Controllers\Admin;

use App\Enums\KycStatus;
use App\Http\Controllers\Controller;
use App\Services\Contracts\Admin\KycServiceInterface;
use App\Traits\Alert;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class kycRequestController extends Controller
{
    use Alert;

    public function __construct(
        protected KycServiceInterface $kycService
    ) {}

    public function index()
    {
        $kycRequests = $this->kycService->getAllKyc();
        // dd($kycRequests);

        // dd($kycRequests->toArray());

        return view('admin.kyc.index', compact('kycRequests'));
    }

    public function show(string $id)
    {
        try {
            $kyc = $this->kycService->getKycById($id);
            return view('admin.kyc.show', compact('kyc'));
        } catch (\Exception $e) {
            logger()->error('Failed to get request data: ' . $e->getMessage());
            redirect()->back();
        }
    }

    public function download(int $kycId)
    {
        try {
            return $this->kycService->downloadDocument($kycId);
        } catch (\Exception $e) {
            logger()->error('Failed to download document: ' . $e->getMessage());

            $this->failed('Unable to download document at the moment!');

            return redirect()->back();
        }
    }

    public function updateStatus(Request $request, int $kycId)
    {
        $request->validate([
            'status' => ['required', 'string', Rule::enum(KycStatus::class)]
        ]);

        // dd($request->all());

        try {
            $kyc = $this->kycService->updateKycStatus($kycId, $request->status);
            $this->created('Status updated successfully');

            return redirect()->route('admin.kyc.index');
        } catch (\Exception $e) {
            logger()->error('Failed to update status: ' . $e->getMessage());

            $this->failed('An error occured while updating status');
            return redirect()->back();
        }
    }

    public function pending(Request $request)
    {
        try {
            $pendingKyc = $this->kycService->getKycByStatus(KycStatus::PENDING->value);
            return view('admin.kyc.pending', compact('pendingKyc'));
        } catch (\Exception $e) {
            logger()->error('Failed to get request data: ' . $e->getMessage());
            redirect()->back();
        }
    }

    public function rejected(Request $request)
    {
        try {
            $rejectedKyc = $this->kycService->getKycByStatus(KycStatus::REJECTED->value);
            return view('admin.kyc.rejected', compact('rejectedKyc'));
        } catch (\Exception $e) {
            logger()->error('Failed to get request data: ' . $e->getMessage());
            redirect()->back();
        }
    }

    public function approved(Request $request)
    {
        try {
            $approvedKyc = $this->kycService->getKycByStatus(KycStatus::APPROVED->value);
            return view('admin.kyc.approved', compact('approvedKyc'));
        } catch (\Exception $e) {
            logger()->error('Failed to get request data: ' . $e->getMessage());
            redirect()->back();
        }
    }

    public function underReview(Request $request)
    {
        try {
            $underReview = $this->kycService->getKycByStatus(KycStatus::UNDER_REVIEW->value);
            return view('admin.kyc.under-review', compact('underReview'));
        } catch (\Exception $e) {
            logger()->error('Failed to get request data: ' . $e->getMessage());
            redirect()->back();
        }
    }
}
