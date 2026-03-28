@extends('emails.layout.app')

@section('content')
    <div class="header" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
        <h1>📋 KYC Submission Received</h1>
    </div>

    <div class="content">
        <p>Dear <strong>{{ $vendor->name }}</strong>,</p>

        <p>We have successfully received your KYC verification documents.</p>

        <div style="text-align: center; margin: 30px 0;">
            <span class="status-badge" style="background: #f59e0b; color: white;">PENDING</span>
        </div>

        <p>Your application is now in queue and will be reviewed shortly.</p>

        <p>Thank you for your patience.</p>
    </div>

    <div class="footer">
        &copy; {{ date('Y') }} {{ config('app.name') }}
    </div>
@endsection
