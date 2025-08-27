<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>@yield('title') - {{ config('app.name') }}</title>
    <meta name="Description" content="">
    <meta name="Author" content="">
    <meta name="keywords" content="">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <!-- Bootstrap Css -->
    <link id="style" href="{{ asset('assets/libs/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Style Css -->
    <link href="{{ asset('assets/css/styles.css') }}" rel="stylesheet">

    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet">
</head>

<body>
    <!-- Loader -->
    <div id="loader">
        <img src="{{ asset('assets/images/media/media-75.svg') }}" alt="">
    </div>
    <!-- Loader -->

    <div class="page">

        <header class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container">
                <a class="navbar-brand fw-bold" href="#">
                    BUBBLE JJ
                </a>

                <a href="#!" id="logout-btn" class="btn btn-danger">
                    Logout
                </a>
            </div>
        </header>

        <div class="container py-3">
            @yield('content')
        </div>

        <!-- Footer Start -->
        <footer class="footer mt-auto py-3 px-0 bg-white text-center">
            <div class="container">
                <small class="text-muted">
                    Copyright ©<span id="year"></span>
                    <a href="https://www.livetok.online/license.html" target="_blank" class="text-dark fw-semibold">
                        PT Digjaya Mahakarya Teknologi
                    </a>. All rights reserved
                </small>
            </div>
        </footer>
        <!-- Footer End -->

    </div>

    <div class="scrollToTop">
        <a href="javascript:void(0);" class="arrow"><i class="las la-angle-double-up fs-20 text-fixed-white"></i></a>
    </div>

    <div id="responsive-overlay"></div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
        @method('POST')
    </form>

    <!-- Main Theme Js -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <!-- JQuery JS -->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>

    <!-- Date & Time Picker JS -->
    <script src="{{ asset('assets/libs/moment/moment.js') }}"></script>

    <!-- Popper JS -->
    <script src="{{ asset('assets/libs/@popperjs/core/umd/popper.min.js') }}"></script>

    <!-- Bootstrap JS -->
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Sweetalert2 JS -->
    <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.all.min.js') }}"></script>

    <script>
        let date = moment(new Date());
        $("#year").text(date.format("YYYY"));

        // Logout Handler
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

    @include('sweetalert::alert')

    @stack('script')
</body>

</html>
