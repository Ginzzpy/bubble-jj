<aside class="app-sidebar sticky" id="sidebar">

    <!-- Start::main-sidebar-header -->
    <div class="main-sidebar-header">
        <a href="{{ route('dashboard') }}" class="header-logo">
            <img src="{{ asset('assets/images/brand-logos/desktop-logo.png') }}" alt="logo" class="desktop-logo">
            <img src="{{ asset('assets/images/brand-logos/toggle-logo.png') }}" alt="logo" class="toggle-logo">
            <img src="{{ asset('assets/images/brand-logos/desktop-dark.png') }}" alt="logo" class="desktop-dark">
            <img src="{{ asset('assets/images/brand-logos/toggle-dark.png') }}" alt="logo" class="toggle-dark">
        </a>
    </div>
    <!-- End::main-sidebar-header -->

    <!-- Start::main-sidebar -->
    <div class="main-sidebar" id="sidebar-scroll">

        <!-- Start::nav -->
        <nav class="main-menu-container nav nav-pills flex-column sub-open">
            <div class="slide-left" id="slide-left">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24"
                    viewBox="0 0 24 24">
                    <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path>
                </svg>
            </div>
            <ul class="main-menu">
                @php
                    function isActive($route)
                    {
                        return request()->routeIs($route) ? 'active' : '';
                    }
                @endphp

                <!-- Start::slide -->
                <li class="slide">
                    <a href="{{ route('dashboard') }}" class="side-menu__item {{ isActive('dashboard') }}">
                        <span class="side-menu__icon">
                            <i class='fe fe-airplay'></i>
                        </span>
                        <span class="side-menu__label">Dashboard</span>
                    </a>
                </li>
                <!-- End::slide -->

                <!-- Start::slide -->
                <li class="slide">
                    @role(['super'])
                        <a href="{{ route('admin.index') }}" class="side-menu__item {{ isActive('admin.*') }}">
                            <span class="side-menu__icon">
                                <i class='fe fe-users'></i>
                            </span>
                            <span class="side-menu__label">Data Admin</span>
                        </a>
                    @endrole
                </li>
                <!-- End::slide -->

                <!-- Start::slide -->
                <li class="slide">
                    <a href="{{ route('order.index') }}" class="side-menu__item {{ isActive('order.*') }}">
                        <span class="side-menu__icon">
                            <i class='fe fe-upload'></i>
                        </span>
                        <span class="side-menu__label">Orderan</span>
                    </a>
                </li>
                <!-- End::slide -->

                <!-- Start::slide -->
                <li class="slide">
                    <a href="{{ route('admin.order.history') }}"
                        class="side-menu__item {{ isActive('admin.order.history') }}"">
                        <span class="side-menu__icon">
                            <i class='fe fe-clock'></i>
                        </span>
                        <span class="side-menu__label">Riwayat Order</span>
                    </a>
                </li>
                <!-- End::slide -->

                <!-- Start::slide -->
                <li class="slide">
                    <a href="{{ route('data.jj') }}" class="side-menu__item {{ isActive('data.jj') }}">
                        <span class="side-menu__icon">
                            <i class='fe fe-video'></i>
                        </span>
                        <span class="side-menu__label">Video JJ</span>
                    </a>
                </li>
                <!-- End::slide -->
            </ul>
            <div class="slide-right" id="slide-right">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24"
                    viewBox="0 0 24 24">
                    <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path>
                </svg>
            </div>
        </nav>
        <!-- End::nav -->

    </div>
    <!-- End::main-sidebar -->

</aside>
