    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <a href="{{ route('dashboard') }}" class="logo d-flex align-items-center">
                <img src="{{ asset('frontend/img/logouis.png') }}" alt="Logo Universitas Ibnu Sina" style="height: 38px; max-height: 38px;">
                <span class="d-none d-lg-block ms-2 fw-bold" style="font-size: 16px; color: {{ $themeSetting->admin_header_brand_color ?? '#FED802' }}; letter-spacing: 0.5px;">Portal UIS</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn ms-2" style="color: {{ $themeSetting->admin_header_text_color ?? '#ffffff' }}; font-size: 26px; cursor: pointer;"></i>
        </div><!-- End Logo -->

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">

                <li class="nav-item me-3 d-none d-md-block">
                    <a href="{{ route('homepage') }}" target="_blank" class="btn btn-sm rounded-pill px-3 py-1" style="font-size: 12.5px; background: {{ $themeSetting->admin_accent_color ?? '#FED802' }}; color: {{ $themeSetting->admin_primary_color ?? '#046B26' }}; font-weight: 700; border: none; box-shadow: 0 2px 6px rgba(0,0,0,0.15);">
                        <i class="bi bi-globe2 me-1"></i> Website Utama
                    </a>
                </li>

                <li class="nav-item dropdown pe-3">
                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold shadow-sm"
                             style="width:36px;height:36px;background: {{ $themeSetting->admin_accent_color ?? '#FED802' }}; color: {{ $themeSetting->admin_primary_color ?? '#046B26' }}; border: 2px solid rgba(255,255,255,0.4); font-size:13px;">
                            {{ strtoupper(substr(Auth::user()->name ?? 'AD', 0, 2)) }}
                        </div>
                        <span class="d-none d-md-block dropdown-toggle ps-2 fw-semibold" style="color: {{ $themeSetting->admin_header_text_color ?? '#ffffff' }};">{{ Auth::user()->name ?? 'Admin' }}</span>
                    </a><!-- End Profile Image Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header text-start">
                            <h6 class="mb-0 fw-bold" style="color: {{ $themeSetting->admin_primary_color ?? '#046B26' }};">{{ Auth::user()->name ?? 'Admin' }}</h6>
                            <span class="text-muted small">{{ ucfirst(Auth::user()->roles ?? 'admin') }} — UIS</span>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('user.my-profile') }}">
                                <i class="bi bi-person me-2" style="color: {{ $themeSetting->admin_primary_color ?? '#046B26' }};"></i>
                                <span>My Profile</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('user.my-profile') }}">
                                <i class="bi bi-key me-2" style="color: #b45309;"></i>
                                <span>Update Password</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center text-danger" href="{{ route('logout') }}" onclick="return confirmLogout(event, '{{ route('logout') }}')">
                                <i class="bi bi-box-arrow-right me-2 text-danger"></i>
                                <span class="fw-semibold">Sign Out</span>
                            </a>
                        </li>

                    </ul><!-- End Profile Dropdown Items -->
                </li><!-- End Profile Nav -->

            </ul>
        </nav><!-- End Icons Navigation -->

    </header><!-- End Header -->