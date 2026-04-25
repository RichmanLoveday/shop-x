@extends('emails.layout.app')

@section('content')
    <div class="header">
        <h1>🎉 Digital File Ready</h1>
    </div>

    <div class="content">
        <p>Dear <strong>{{ $user->name ?? 'User' }}</strong>,</p>

        <p>Great news! Your digital product has been successfully uploaded and processed.</p>

        <div class="card">
            <p><strong>Product:</strong> {{ $productName }}</p>
            <p><strong>File Name:</strong> {{ $fileName }}</p>
            <p><strong>Created By:</strong> {{ $creatorName }}</p>
        </div>

        <div style="text-align: center; margin: 30px 0;">
            <span class="status-badge" style="background: #10b981; color: white;">
                UPLOADED SUCCESSFULLY
            </span>
        </div>

        <p>Your file is now ready and safely stored on our secure storage system.</p>

        <p>You can now access or manage this file from your dashboard.</p>

        <div style="text-align: center;">
            <a href="{{ route('vendor.dashboard') }}" class="button">
                Go to Dashboard
            </a>
        </div>

        <p style="margin-top: 30px;">
            If you did not initiate this upload, please contact support immediately.
        </p>
    </div>
@endsection
