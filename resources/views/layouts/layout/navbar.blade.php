<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme container-fluid" id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="fa-regular fa-bars fa-fw"></i>
        </a>
    </div>
    <div class="navbar-nav-right d-flex align-items-center justify-content-between" id="navbar-collapse">
        <div class="navbar-nav">
            <div class="nav-item mb-0">
                <small class="fw-normal d-block">Hai, <span id="selamat"></span></small>
                <p class="fw-semibold fs-7 mb-0">{{ Auth::user()?->name }} <span class="text-warning"> ({{ Str::replace('-',' ',Str::title(Auth::user()?->getRoleNames()?->first())) }})</span>
                    {{-- @if (Auth::user()->branch_id) | <span class="text-info">({{ Auth::user()->branch?->name }})</span>@endif --}}
                </p>
            </div>
        </div>
        <div class="navbar-nav">
            <div class="nav-item mb-0">
                {{-- <span class="d-lg-block d-none" id="dateTime"></span> --}}
            </div>
        </div>
        <ul class="navbar-nav align-items-center d-flex gap-1">
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar">
                        <img src="{{ asset('assets/admin/img/avatars/'. rand(1, 15) .'.png') }}" alt class="h-auto rounded-circle">
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li class="dropdown-menu-header p-1">
                        <div class="dropdown-header d-flex align-items-center gap-2">
                            <div class="avatar">
                                <img src="{{ asset('assets/admin/img/avatars/1.png') }}" class="h-auto rounded-circle">
                            </div>
                            <div>
                                {{-- <p class="fw-semibold mb-0 text-dark">{{ Auth::user()->name }}</p>
                                <small class="text-muted">{{ Str::replace('-',' ',Str::title(Auth::user()->getRoleNames()->first())) }}</small> --}}
                            </div>
                        </div>
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center gap-2" href="#" data-bs-toggle="modal" data-bs-target="#modal-change-password">
                            <i class="fa-regular fa-key fa-fw"></i>
                            <span class="align-middle">Ubah Kata Sandi</span>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center gap-2" href="/logout">
                            <i class="fa-regular fa-power-off fa-fw"></i>
                            <span class="align-middle">Keluar</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
