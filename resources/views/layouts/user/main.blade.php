<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-menu-styles="light" loader="disable"
    style="--primary-rgb: 181, 71, 226;" data-default-header-styles="color">

<head>

    <!-- Meta Data -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>@yield('title') - {{ SettingsHelper::get('app_name', config('app.name')) }}</title>
    <meta name="Description" content="{{ SettingsHelper::get('description') }}">
    <meta name="Author" content="{{ SettingsHelper::get('author') }}">
    <meta name="keywords" content="{{ SettingsHelper::get('keywords') }}">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset(SettingsHelper::get('favicon')) }}" type="image/x-icon">

    <!-- Bootstrap Css -->
    <link id="style" href="{{ asset('vendor/libs/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Style Css -->
    <link href="{{ asset('vendor/css/styles.min.css') }}" rel="stylesheet">

    <!-- Icons Css -->
    <link href="{{ asset('vendor/css/icons.css') }}" rel="stylesheet">

    <style>
        .footer {
            position: fixed;
            width: 100%;
            bottom: 0;
            padding: 10px 0;
            text-align: center;
            box-shadow: none;
            z-index: 999;
            background: #fff;
        }
    </style>

</head>

<body>
    <!-- Loader -->
    <div id="loader">
        <img src="{{ asset('vendor/images/media/media-75.svg') }}" alt="">
    </div>
    <!-- Loader -->

    <div class="page">
        @include('layouts.user.navbar')

        <!-- main-user-wrapper -->
        <div class="my-auto">
            <div id="main-content" class="container py-5 my-5 mx-auto">
                @yield('content')
            </div>
        </div>

        <footer class="footer">
            <div class="container">
                <small class="text-muted">
                    Copyright ©<span id="year"></span>
                    <a href="https://www.livetok.online/license.html" target="_blank" class="text-dark fw-semibold">
                        {{ SettingsHelper::get('copyright') }}
                    </a>. All rights reserved
                </small>
            </div>
        </footer>
    </div>

    <div class="scrollToTop">
        <a href="javascript:void(0);" class="arrow">
            <i class="las la-angle-double-up fs-20 text-fixed-white"></i>
        </a>
    </div>

    <div id="responsive-overlay"></div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
        @method('POST')
    </form>

    <script>
        window.appName = @json(SettingsHelper::get('app_name', config('app.name')));
    </script>

    <!-- Main Theme Js -->
    <script src="{{ asset('vendor/js/main.js') }}"></script>

    <!-- JQuery JS -->
    <script src="{{ asset('vendor/libs/jquery/dist/jquery.min.js') }}"></script>

    <!-- Date & Time Picker JS -->
    <script src="{{ asset('vendor/libs/moment/moment.js') }}"></script>

    {{-- Bootstrap JS --}}
    <script src="{{ asset('vendor/js/landing/bootstrap.min.js') }}"></script>

    <!-- Sweetalert2 JS -->
    <script src="{{ asset('vendor/libs/sweetalert2/sweetalert2.all.min.js') }}"></script>

    <!-- SPA JS -->
    <script src="{{ asset('assets/js/script.js') }}"></script>

    <!-- Copyright year handler -->
    <script>
        let date = moment(new Date());
        $("#year").text(date.format("YYYY"));
    </script>

    <!-- Logout handler -->
    <script>
        $(document).on("click", "#logout-btn", function(e) {
            e.preventDefault();
            Swal.fire({
                title: "Apakah Anda yakin ingin keluar?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#dc3545",
                cancelButtonColor: "#adb5bd",
                confirmButtonText: "Ya, Keluar",
                cancelButtonText: "Batal",
            }).then((result) => {
                if (result.isConfirmed) {
                    $("#logout-form").submit();
                }
            });
        });
    </script>

    @yield('scripts')
</body>
