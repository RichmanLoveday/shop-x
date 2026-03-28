<?php

namespace App\Services;

use App\Mail\KycApproved;
use App\Mail\KycPending;
use App\Mail\KycRejected;
use App\Models\Kyc;
use Illuminate\Support\Facades\Mail;

class MailService
{
    public static function sendKycApproveMail(Kyc $kyc): void
    {
        $vendor = $kyc?->vendor;
        Mail::to($vendor)->queue(new KycApproved($kyc, $vendor));
    }

    public static function sendKycRejected(Kyc $kyc): void
    {
        $vendor = $kyc?->vendor;
        Mail::to($vendor)->queue(new KycRejected($kyc, $vendor));
    }

    public static function sendkycPending(Kyc $kyc): void
    {
        $vendor = $kyc?->vendor;
        Mail::to($vendor)->queue(new KycPending($kyc, $vendor));
    }
}