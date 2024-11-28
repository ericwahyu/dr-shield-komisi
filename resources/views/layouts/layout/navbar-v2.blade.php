<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0 d-xl-none ">
        {{-- <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
            <i class="bx bx-menu bx-md"></i>
        </a> --}}
    </div>
    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        <ul class="navbar-nav flex-row align-items-center ms-auto">
            <!-- Quick links -->
            <!-- User -->
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
            <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);" data-bs-toggle="dropdown">
                <div class="avatar avatar-online">
                    <img src="{{ asset('assets-v2/img/avatars/1.png') }}" alt="" class="w-px-40 h-auto rounded-circle">
                </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <a class="dropdown-item" href="pages-account-settings-account.html">
                        <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                                <div class="avatar avatar-online">
                                <img src="{{ asset('assets-v2/img/avatars/1.png') }}" alt="" class="w-px-40 h-auto rounded-circle">
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-0">John Doe</h6>
                                <small class="text-muted">Admin</small>
                            </div>
                        </div>
                    </a>
                </li>
                <li>
                    <div class="dropdown-divider my-1"></div>
                </li>
                <li>
                    <a class="dropdown-item" href="pages-profile-user.html">
                    <i class="bx bx-user bx-md me-3"></i><span>My Profile</span>
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="pages-account-settings-account.html">
                    <i class="bx bx-cog bx-md me-3"></i><span>Settings</span>
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="pages-account-settings-billing.html">
                        <span class="d-flex align-items-center align-middle">
                            <i class="flex-shrink-0 bx bx-credit-card bx-md me-3"></i>
                            <span class="flex-grow-1 align-middle">Billing Plan</span>
                            <span class="flex-shrink-0 badge rounded-pill bg-danger">4</span>
                        </span>
                    </a>
                </li>
                <li>
                    <div class="dropdown-divider my-1"></div>
                </li>
                <li>
                    <a class="dropdown-item" href="pages-pricing.html">
                    <i class="bx bx-dollar bx-md me-3"></i><span>Pricing</span>
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="pages-faq.html">
                    <i class="bx bx-help-circle bx-md me-3"></i><span>FAQ</span>
                    </a>
                </li>
                <li>
                    <div class="dropdown-divider my-1"></div>
                </li>
                <li>
                    <a class="dropdown-item" href="auth-login-cover.html" target="_blank">
                    <i class="bx bx-power-off bx-md me-3"></i><span>Log Out</span>
                    </a>
                </li>
            </ul>
            </li>
            <!--/ User -->


        </ul>
    </div>
    <!-- Search Small Screens -->
    <div class="navbar-search-wrapper search-input-wrapper  d-none">
        <input type="text" class="form-control search-input container-xxl border-0" placeholder="Search..." aria-label="Search...">
        <i class="bx bx-x bx-md search-toggler cursor-pointer"></i>
    </div>
</nav>
