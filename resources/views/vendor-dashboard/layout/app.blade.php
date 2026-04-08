<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Dashboard - Tabler - Premium and Open Source dashboard template with responsive and high quality UI.</title>
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link href="{{ asset('assets/admin/libs/jsvectormap/dist/jsvectormap.css?1750026893') }}" rel="stylesheet" />
    <!-- END PAGE LEVEL STYLES -->
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="{{ asset('assets/admin/css/tabler.css?1750026893') }}" rel="stylesheet" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PLUGINS STYLES -->
    <link href="{{ asset('assets/admin/css/tabler-flags.css?1750026893') }}" rel="stylesheet" />
    <link href="{{ asset('assets/admin/css/tabler-socials.css?1750026893') }}" rel="stylesheet" />
    <link href="{{ asset('assets/admin/css/tabler-payments.css?1750026893') }}" rel="stylesheet" />
    <link href="{{ asset('assets/admin/css/tabler-vendors.css?1750026893') }}" rel="stylesheet" />
    <link href="{{ asset('assets/admin/css/tabler-marketing.css?1750026893') }}" rel="stylesheet" />
    <link href="{{ asset('assets/admin/css/tabler-themes.css?1750026893') }}" rel="stylesheet" />
    <!-- END PLUGINS STYLES -->
    <!-- BEGIN DEMO STYLES -->
    <link rel="stylesheet" href="{{ asset('assets/global/upload-preview/upload-preview.css') }}">
    <link href="{{ asset('assets/admin/preview/css/demo.css?1750026893') }}" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- END DEMO STYLES -->
    <!-- BEGIN CUSTOM FONT -->
    <style>
        @import url("https://rsms.me/inter/inter.css");
    </style>
    <!-- END CUSTOM FONT -->
</head>

<body>
    <!-- BEGIN GLOBAL THEME SCRIPT -->
    <script src="{{ asset('assets/admin/js/tabler-theme.min.js?1750026893') }}"></script>
    <!-- END GLOBAL THEME SCRIPT -->
    <div class="page">
        @include('vendor-dashboard.layout.sidebar')
        <div class="page-wrapper">

            <!-- BEGIN PAGE BODY -->
            <div class="page-body">
                @yield('contents')
            </div>
            <!-- END PAGE BODY -->
            @include('vendor-dashboard.layout.footer')
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-4.0.0.min.js"
        integrity="sha256-OaVG6prZf4v69dPg6PhVattBXkcOWQB62pdZ3ORyrao=" crossorigin="anonymous"></script>

    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="{{ asset('assets/admin/js/tabler.min.js?1750026893') }}" defer></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->
    <!-- BEGIN DEMO SCRIPTS -->
    <script src="{{ asset('assets/admin/preview/js/demo.min.js?1750026893') }}" defer></script>
    <!-- END DEMO SCRIPTS -->

    <script src="{{ asset('assets/global/ckeditor/ckeditor.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    @include('vendor-dashboard.layout.scripts')
    @stack('scripts')
</body>

</html>
