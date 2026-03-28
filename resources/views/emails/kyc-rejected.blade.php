@extends('emails.layout.app')

@section('content')
    <div class="header" style="background: linear-gradient(135deg, #ef4444 0%, #b91c1c 100%);">
        <h1>❌ KYC Verification Rejected</h1>
    </div>

    <div class="content">
        <p>Dear <strong>{{ $vendor->name }}</strong>,</p>

        <p>Unfortunately, your KYC verification has been <strong>rejected</strong>.</p>

        <div style="text-align: center; margin: 30px 0;">
            <span class="status-badge" style="background: #ef4444; color: white;">REJECTED</span>
        </div>

        <p><strong>Reason:</strong></p>
        <p style="background: #fee2e2; padding: 15px; border-radius: 6px;">
            {{ $reason ?? 'Testing' }}
        </p>

        <p>You can resubmit your KYC with the corrected documents.</p>

        <div style="text-align: center;">
            <a href="{{ route('kyc.index') }}" class="button">Resubmit KYC</a>
        </div>
    </div>

    <div class="footer">
        &copy; {{ date('Y') }} {{ config('app.name') }}
    </div>
@endsection
