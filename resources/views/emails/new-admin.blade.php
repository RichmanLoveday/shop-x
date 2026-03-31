@extends('emails.layout.app')

@section('header')
    <div class="header" style="background: linear-gradient(135deg, #4f46e5, #7c3aed);">
        <h1>🚀 Welcome to {{ config('app.name') }}</h1>
        <p>Your admin account has been created</p>
    </div>
@endsection

@section('content')
    <p>Hello <strong>{{ $name }}</strong>,</p>

    <p>
        You’ve been granted <strong>Admin Access</strong>.
        Below are your login credentials:
    </p>

    <div class="card">
        <p><strong>Email:</strong></p>
        <p>{{ $email }}</p>

        <p><strong>Password:</strong></p>
        <p style="background:#111827;color:#fff;padding:10px;border-radius:6px;font-family:monospace;">
            {{ $password }}
        </p>
    </div>

    <div style="text-align:center;">
        <a href="{{ route('admin.login') }}" class="button">
            Login to Dashboard
        </a>
    </div>

    <p style="font-size: 14px; color: #6b7280;">
        ⚠️ Please change your password after your first login.
    </p>

    <p>
        Welcome aboard,<br>
        <strong>{{ config('app.name') }} Team</strong>
    </p>
@endsection
