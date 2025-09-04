<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container">
        <a class="navbar-brand" href="#">
            <img src="{{ asset(SettingsHelper::get('logo')) }}" alt="logo" class="img-fluid" style="max-width: 100px; height: auto;">
        </a>
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link text-danger" href="#!" id="logout-btn">
                    <i class='mdi mdi-logout'></i>
                    Logout
                </a>
            </li>
        </ul>
    </div>
</nav>
