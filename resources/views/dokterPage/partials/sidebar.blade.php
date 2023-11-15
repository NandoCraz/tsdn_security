<aside class="page-sidebar">
    <div class="page-logo">
        <a href="/" class="page-logo-link press-scale-down d-flex align-items-center position-relative"
            data-toggle="modal" data-target="#modal-shortcut">
            <img src="{{ asset('assets/dashboard/img/logo.png') }}" alt="SmartAdmin WebApp" aria-roledescription="logo">
            <span class="page-logo-text mr-1">Face Recognition</span>
            <span class="position-absolute text-white opacity-50 small pos-top pos-right mr-2 mt-n2"></span>
            <i class="fal fa-angle-down d-inline-block ml-1 fs-lg color-primary-300"></i>
        </a>
    </div>
    <!-- BEGIN PRIMARY NAVIGATION -->
    <nav id="js-primary-nav" class="primary-nav" role="navigation">
        <div class="nav-filter">
            <div class="position-relative">
                <input type="text" id="nav_filter_input" placeholder="Filter menu" class="form-control"
                    tabindex="0">
                <a href="#" onclick="return false;" class="btn-primary btn-search-close js-waves-off"
                    data-action="toggle" data-class="list-filter-active" data-target=".page-sidebar">
                    <i class="fal fa-chevron-up"></i>
                </a>
            </div>
        </div>
        <div class="info-card">
            <img src="{{ asset('assets/dashboard/img/demo/avatars/avatar-admin.png') }}"
                class="profile-image rounded-circle" alt="Dr. Codex Lantern">
            <div class="info-card-text">
                <a href="/" class="d-flex align-items-center text-white">
                    <span class="text-truncate text-truncate-sm d-inline-block ">
                        Es Tech
                    </span>
                </a>
                <span class="d-inline-block text-truncate text-truncate-sm fs-sm">UNESA, Surabaya</span>
            </div>
            <img src="{{ asset('assets/dashboard/img/card-backgrounds/cover-2-lg.png') }}" class="cover"
                alt="cover">
            <a href="#" onclick="return false;" class="pull-trigger-btn" data-action="toggle"
                data-class="list-filter-active" data-target=".page-sidebar" data-focus="nav_filter_input">
                <i class="fal fa-angle-down"></i>
            </a>
        </div>
        <ul id="js-nav-menu" class="nav-menu">
            <li class="{{ Request::Is('/') ? 'active' : '' }}">
                <a href="/" title="Basic Tables" data-filter-tags="dashboard">
                    <span class="nav-link-text" data-i18n="nav.tables_basic_tables"><i class="fa fa-tachometer mr-2"
                            aria-hidden="true"></i> Dashboard</span>
                </a>
            </li>
            @if (auth()->user()->role == 'dokter')
                <li class="{{ Request::Is('data-pasien') ? 'active' : '' }}">
                    <a href="/data-pasien" title="Basic Tables" data-filter-tags="data pasien">
                        <span class="nav-link-text" data-i18n="nav.tables_basic_tables"><i class="fa fa-list mr-2"
                                aria-hidden="true"></i> Data Pasien</span>
                    </a>
                </li>
            @endif

        </ul>
        <div class="filter-message js-filter-message bg-success-600"></div>
    </nav>
    <!-- END PRIMARY NAVIGATION -->
    <!-- NAV FOOTER -->
    <div class="nav-footer shadow-top">
        <a href="#" onclick="return false;" data-action="toggle" data-class="nav-function-minify"
            class="hidden-md-down">
            <i class="ni ni-chevron-right"></i>
            <i class="ni ni-chevron-right"></i>
        </a>
    </div> <!-- END NAV FOOTER -->
</aside>
