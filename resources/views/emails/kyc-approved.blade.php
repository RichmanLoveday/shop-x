@extends('emails.layout.app')

@section('content')
    <div class="header">
        <h1>✅ KYC Verification Approved</h1>
    </div>

    <div class="content">
        <p>Dear <strong>{{ $vendor->name }}</strong>,</p>

        <p>We are pleased to inform you that your KYC verification has been <strong>successfully approved</strong>.</p>

        <div style="text-align: center; margin: 30px 0;">
            <span class="status-badge" style="background: #10b981; color: white;">APPROVED</span>
        </div>

        <p><strong>Approval Date:</strong> {{ $kyc->verified_at->format('d F, Y \a\t h:i A') }}</p>

        <p>You can now enjoy full access to all vendor features including:</p>
        <ul>
            <li>Adding and managing products</li>
            <li>Receiving customer orders</li>
            <li>Processing withdrawals</li>
            <li>Access to vendor dashboard</li>
        </ul>

        <div style="text-align: center;">
            <a href="{{ route('vendor.dashboard') }}" class="button">Go to Vendor Dashboard</a>
        </div>

        <p>If you have any questions, feel free to contact our support team.</p>
    </div>

    <div class="footer">
        &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
    </div>
@endsection
