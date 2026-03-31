<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject ?? config('app.name') }}</title>

    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 12px;
            /* smoother */
            overflow: hidden;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
            /* softer shadow */
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }

        .content {
            padding: 40px 30px;
            line-height: 1.6;
            color: #333;
        }

        .footer {
            background: #f8f9fa;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #777;
        }

        .button {
            display: inline-block;
            padding: 12px 24px;
            background: #4f46e5;
            color: white !important;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            margin: 20px 0;
        }

        .card {
            margin: 25px 0;
            padding: 20px;
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
        }

        .status-badge {
            padding: 8px 16px;
            border-radius: 9999px;
            font-weight: bold;
            display: inline-block;
            margin: 10px 0;
        }
    </style>

    @yield('styles') {{-- optional extension --}}
</head>

<body>
    <div class="container">

        {{-- Header (customizable) --}}
        @hasSection('header')
            @yield('header')
        @else
            <div class="header">
                <h1>{{ config('app.name') }}</h1>
            </div>
        @endif

        {{-- Content --}}
        <div class="content">
            @yield('content')
        </div>

        {{-- Footer --}}
        <div class="footer">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </div>

    </div>
</body>

</html>
