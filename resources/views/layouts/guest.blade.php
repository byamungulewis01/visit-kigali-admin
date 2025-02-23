<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">
<head>
    <meta charset="utf-8" />
    <title>{{ config('app.name', 'Visit Kigali App') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content="Visit Kigali System" name="description" />
    <meta content="BmgCodes" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}">

    <!-- Layout config Js -->
    {{-- <script src="{{ asset('assets/js/layout.js"></script> --}}
    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    {{-- <link href="{{ asset('assets/css/custom.min.css') }}" rel="stylesheet" type="text/css" /> --}}

</head>

<body>

    <div class="auth-page-wrapper pt-5">

        <!-- auth page content -->
        <div class="auth-page-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center mt-sm-5 mb-4 text-white-50">
                            <div>
                                <a href="{{ route('login') }}" class="d-inline-block auth-logo">
                                    <img src="{{ asset('logo.png') }}" alt="Logo" height="50">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        {{ $slot }}
                        <!-- end card -->

                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end auth page content -->


    {{-- <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/js/plugins.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/libs/particles.js/particles.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/js/pages/particles.app.js') }}"></script> --}}
    <script src="{{ asset('assets/js/pages/password-addon.init.js') }}"></script>
</body>
</html>
