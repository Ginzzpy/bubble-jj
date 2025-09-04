<header class="app-header">
    <div class="main-header-container container-fluid">
        <div class="header-content-left">
            <div class="header-element">
                <div class="horizontal-logo">
                    <a class="header-logo" href="{{ route('user.dashboard') }}">
                        <img src="{{ asset(SettingsHelper::get('logo')) }}" alt="logo">
                    </a>
                </div>
            </div>
        </div>
        <div class="header-content-right">
            <div class="header-element d-flex align-items-center">
                <a class="btn btn-danger" href="#!" id="logout-btn">
                    <i class='mdi mdi-logout'></i>
                    Logout
                </a>
            </div>
        </div>
    </div>
</header>
