<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo" style="margin-top: 15px">
        <a href="#">
            <span class="app-brand-logo">
                <img src="{{ asset('assets/image/logo-drshield.png') }}" style="object-fit: contain;width: 150px; margin-top: 10px; margin-left: 9px; margin-bottom: 10px">
            </span>
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            {{-- <i class="fa-regular fa-circle-dot d-none d-xl-block fa-sm align-middle"></i> --}}
            <i class="fa-regular fa-xmark d-block d-xl-none fa-sm align-middle"></i>
        </a>
    </div>
    <div class="menu-inner-shadow" style="display: none; margin-top: 25px"></div>
    <ul class="menu-inner py-0">
        {{-- <li class="menu-header small text-uppercase">
            <span class="menu-header-text" style="font-size: 15px;color: black;">DASHBOARD</span>
        </li> --}}
        {{-- <li class="menu-item {{ Request::is('*dashboard') ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}" class="menu-link">
                <i class="fa-regular fa-home-alt fa-fw me-2"></i>
                <div>Dashboard</div>
            </a>
        </li> --}}
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text" style="font-size: 15px;color: black;">DATA SALES</span>
        </li>
        <li class="menu-item {{ Request::is('*sales/daftar*', '*sales/batas-bawah-target*') ? 'active' : '' }}">
            <a href="{{ route('sales.list') }}" class="menu-link">
                <i class="fa-regular fa-home-alt fa-fw me-2"></i>
                <div>Daftar Sales</div>
            </a>
        </li>
        {{-- <li class="menu-item {{ Request::is('*pelanggan/calon*') ? 'active' : '' }}">
            <a href="{{ route('customer.potential') }}" class="menu-link">
                <i class="fa-regular fa-home-alt fa-fw me-2"></i>
                <div>Calon Pelanggan</div>
            </a>
        </li>
        <li class="menu-item {{ Request::is('*pelanggan/penjualan-toko*') ? 'active' : '' }}">
            <a href="{{ route('customer.store.sale') }}" class="menu-link">
                <i class="fa-regular fa-home-alt fa-fw me-2"></i>
                <div>Penjualan Toko</div>
            </a>
        </li>
        <li class="menu-item {{ Request::is('*pelanggan/proyek*') ? 'active' : '' }}">
            <a href="{{ route('customer.project') }}" class="menu-link">
                <i class="fa-regular fa-home-alt fa-fw me-2"></i>
                <div>Proyek</div>
            </a>
        </li>
        <li class="menu-item {{ Request::is('*pelanggan/e-commerce*') ? 'active' : '' }}">
            <a href="{{ route('customer.e-commerce') }}" class="menu-link">
                <i class="fa-regular fa-home-alt fa-fw me-2"></i>
                <div>E-Commerce</div>
            </a>
        </li>
        <li class="menu-item {{ Request::is('*pelanggan/persentase*') ? 'active' : '' }}">
            <a href="{{ route('customer.percentage') }}" class="menu-link">
                <i class="fa-regular fa-home-alt fa-fw me-2"></i>
                <div>Persentase Pelanggan</div>
            </a>
        </li> --}}
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text" style="font-size: 15px;color: black;">FAKTUR</span>
        </li>
        <li class="menu-item {{ Request::is('*faktur/keramik*') ? 'active' : '' }}">
            <a href="{{ route('ceramic.invoice') }}" class="menu-link">
                <i class="fa-regular fa-home-alt fa-fw me-2"></i>
                <div>Faktur Keramik</div>
            </a>
        </li>
        <li class="menu-item {{ Request::is('*faktur/atap*') ? 'active' : '' }}">
            <a href="{{ route('roof.invoice') }}" class="menu-link">
                <i class="fa-regular fa-home-alt fa-fw me-2"></i>
                <div>Faktur Atap</div>
            </a>
        </li>
        {{-- <li class="menu-item {{ Request::is('*pesanan/genteng*') ? 'active' : '' }}">
            <a href="{{ route('order.roof') }}" class="menu-link">
                <i class="fa-regular fa-home-alt fa-fw me-2"></i>
                <div>Pesanan Genteng</div>
            </a>
        </li>
        <li class="menu-item {{ Request::is('*pesanan/UPVC*') ? 'active' : '' }}">
            <a href="{{ route('order.upvc') }}" class="menu-link">
                <i class="fa-regular fa-home-alt fa-fw me-2"></i>
                <div>Pesanan UPVC</div>
            </a>
        </li> --}}
        {{-- <li class="menu-item {{ Request::is('*pesanan/riwayat*') ? 'active' : '' }}">
            <a href="{{ route('order.history') }}" class="menu-link">
                <i class="fa-regular fa-home-alt fa-fw me-2"></i>
                <div>Riwayat Pesanan</div>
            </a>
        </li> --}}
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text" style="font-size: 15px;color: black;">KOMISI</span>
        </li>
        <li class="menu-item {{ Request::is('*komisi/keramik*') ? 'active' : '' }}">
            <a href="{{ route('ceramic.commission') }}" class="menu-link">
                <i class="fa-regular fa-home-alt fa-fw me-2"></i>
                <div>Komisi Sales Keramik</div>
            </a>
        </li>
        <li class="menu-item {{ Request::is('*komisi/atap*') ? 'active' : '' }}">
            <a href="{{ route('roof.commission') }}" class="menu-link">
                <i class="fa-regular fa-home-alt fa-fw me-2"></i>
                <div>Komisi Sales Atap</div>
            </a>
        </li>
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text" style="font-size: 15px;color: black;">PENGATURAN</span>
        </li>
        <li class="menu-item {{ Request::is('*komisi/target-aktual*') ? 'active' : '' }}">
            <a href="{{ route('actual.target.commission') }}" class="menu-link">
                <i class="fa-regular fa-home-alt fa-fw me-2"></i>
                <div>Target Aktual Atap</div>
            </a>
        </li>
        <li class="menu-item {{ Request::is('*pengaturan/reset-data-faktur') ? 'active' : '' }}">
            <a href="{{ route('factur-reset') }}" class="menu-link">
                <i class="fa-regular fa-home-alt fa-fw me-2"></i>
                <div>Reset Data Faktur</div>
            </a>
        </li>
        {{-- <li class="menu-item {{ Request::is('*perhitungan/aksesoris') ? 'active' : '' }}">
            <a href="{{ route('calculation.accesories') }}" class="menu-link">
                <i class="fa-regular fa-home-alt fa-fw me-2"></i>
                <div>Aksesoris</div>
            </a>
        </li>
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text" style="font-size: 15px;color: black;">PRODUK</span>
        </li>
        <li class="menu-item {{ Request::is('*produk/genteng*') ? 'active' : '' }}">
            <a href="{{ route('product.roof') }}" class="menu-link">
                <i class="fa-regular fa-home-alt fa-fw me-2"></i>
                <div>Data Genteng</div>
            </a>
        </li>
        <li class="menu-item {{ Request::is('*produk/UPVC') ? 'active' : '' }}">
            <a href="{{ route('product.upvc') }}" class="menu-link">
                <i class="fa-regular fa-home-alt fa-fw me-2"></i>
                <div>UPVC</div>
            </a>
        </li>
        <li class="menu-item {{ Request::is('*produk/aksesoris') ? 'active' : '' }}">
            <a href="{{ route('product.accessories') }}" class="menu-link">
                <i class="fa-regular fa-home-alt fa-fw me-2"></i>
                <div>Aksesoris</div>
            </a>
        </li>
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text" style="font-size: 15px;color: black;">MARKETING TOOLS</span>
        </li>
        <li class="menu-item {{ Request::is('*marketing-tool/sample') ? 'active' : '' }}">
            <a href="{{ route('marketing.sample') }}" class="menu-link">
                <i class="fa-regular fa-home-alt fa-fw me-2"></i>
                <div>Stock Sample</div>
            </a>
        </li>
        <li class="menu-item {{ Request::is('*marketing-tool/riwayat-sample') ? 'active' : '' }}">
            <a href="{{ route('marketing.sample.history') }}" class="menu-link">
                <i class="fa-regular fa-home-alt fa-fw me-2"></i>
                <div>Rekap Data Sample</div>
            </a>
        </li> --}}
        {{-- @if (Auth::user()->hasAnyRole('master-admin', 'super-admin'))
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text" style="font-size: 15px;color: black;">MASTER DATA</span>
            </li>
            @if (Auth::user()->hasAnyRole('master-admin'))
                <li class="menu-item {{ Request::is('') ? 'active' : '' }}">
                    <a href="#" class="menu-link">
                        <i class="fa-regular fa-home-alt fa-fw me-2"></i>
                        <div>Super Admin</div>
                    </a>
                </li>
            @endif
            <li class="menu-item {{ Request::is('*master-data/admin') ? 'active' : '' }}">
                <a href="{{ route('master.admin') }}" class="menu-link">
                    <i class="fa-regular fa-home-alt fa-fw me-2"></i>
                    <div>Data Admin</div>
                </a>
            </li>
        {{-- @endif --}}
        {{-- @if (Auth::user()->hasAnyRole('super-admin', 'admin'))
        @endif
        <li class="menu-item {{ Request::is('*keanggotaan/data-anggota/*', '') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="fa-regular fa-boxes fa-fw me-2"></i>
                <div>Data Anggota</div>
            </a>
            <ul class="menu-sub">
                @if (Auth::user()->hasAnyRole('super-admin', 'admin'))
                    <li class="menu-item {{ Request::is('*keanggotaan/data-anggota/data-admin*') ? 'active' : '' }}">
                        <a href="{{ Auth::user()->hasAnyRole('super-admin') ? "/auth/keanggotaan/data-anggota/data-admin" : "/auth/keanggotaan/data-anggota/data-admin/detail/".Auth::user()->id }}" class="menu-link">
                            <div>Data Admin</div>
                        </a>
                    </li>
                @endif
                @if (Auth::user()->hasAnyRole('super-admin', 'admin', 'instruktur'))
                    <li class="menu-item {{ Request::is('*keanggotaan/data-anggota/data-instruktur*') ? 'active' : '' }}">
                        <a href="{{ Auth::user()->hasAnyRole('super-admin', 'admin') ? "/auth/keanggotaan/data-anggota/data-instruktur" : "/auth/keanggotaan/data-anggota/data-instruktur/detail/".Auth::user()->id }}" class="menu-link">
                            <div>Data Instruktur</div>
                        </a>
                    </li>
                @endif
                <li class="menu-item {{ Request::is('*keanggotaan/data-anggota/data-user*') ? 'active' : '' }}">
                    <a href="{{ Auth::user()->hasAnyRole('super-admin', 'admin', 'instruktur') ? "/auth/keanggotaan/data-anggota/data-user" : "/auth/keanggotaan/data-anggota/data-user/detail/".Auth::user()->id }}" class="menu-link">
                        <div>Data User</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text" style="font-size: 15px;color: black;">SERTIFIKASI</span>
        </li>
        @if (Auth::user()->hasAnyRole('super-admin', 'admin', 'instruktur'))
            <li class="menu-item {{ Request::is('*sertifikasi/lokasi-sertifikasi*') ? 'active' : '' }}">
                <a href="/auth/sertifikasi/lokasi-sertifikasi" class="menu-link">
                    <i class="fa-regular fa-home-alt fa-fw me-2"></i>
                    <div>Data Lokasi Sertifikasi</div>
                </a>
            </li>
        @endif
        <li class="menu-item {{ Request::is('*sertifikasi/data-aktifitas*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="fa-regular fa-boxes fa-fw me-2"></i>
                <div>Data Kegiatan</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ Request::is('*sertifikasi/data-aktifitas/kelas-teori*') ? 'active' : '' }}">
                    <a href="{{ Auth::user()->hasAnyRole('super-admin', 'admin', 'instruktur') ? "/auth/sertifikasi/data-aktifitas/kelas-teori" : "/auth/sertifikasi/data-aktifitas/kelas-teori-progress/".Auth::user()->certificationLOcation->id }}" class="menu-link">
                        <div>Kelas Teori</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::is('*sertifikasi/data-aktifitas/ujian-teori*') ? 'active' : '' }}">
                    <a href="{{ Auth::user()->hasAnyRole('super-admin', 'admin', 'instruktur') ? "/auth/sertifikasi/data-aktifitas/ujian-teori" : "/auth/sertifikasi/data-aktifitas/ujian-teori-test/".Auth::user()->certificationLocation->id }}"  class="menu-link">
                        <div>Ujian Teori</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::is('*sertifikasi/data-aktifitas/ujian-praktek*') ? 'active' : '' }}">
                    <a href="/auth/sertifikasi/data-aktifitas/ujian-praktek" class="menu-link">
                        <div>Ujian Praktek</div>
                    </a>
                </li>
            </ul>
        </li>
        @if (Auth::user()->hasAnyRole('super-admin'))
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text" style="font-size: 15px;color: black;">MASTER DATA</span>
            </li>
            <li class="menu-item {{ Request::is('*data-master/data-admin*') ? 'active' : '' }}">
                <a href="/auth/data-master/data-admin" class="menu-link">
                    <i class="fa-regular fa-home-alt fa-fw me-2"></i>
                    <div>Data Admin</div>
                </a>
            </li>
            <li class="menu-item {{ Request::is('*data-master/data-instruktur*') ? 'active' : '' }}">
                <a href="/auth/data-master/data-instruktur" class="menu-link">
                    <i class="fa-regular fa-home-alt fa-fw me-2"></i>
                    <div>Data Instruktur</div>
                </a>
            </li>
            <li class="menu-item {{ Request::is('*data-master/data-peserta*') ? 'active' : '' }}">
                <a href="/auth/data-master/data-peserta" class="menu-link">
                    <i class="fa-regular fa-home-alt fa-fw me-2"></i>
                    <div>Data Peserta</div>
                </a>
            </li>
            <li class="menu-item {{ Request::is('*data-master/bank-soal*') ? 'active' : '' }}">
                <a href="/auth/data-master/bank-soal/daftar-modul" class="menu-link">
                    <i class="fa-regular fa-home-alt fa-fw me-2"></i>
                    <div>Bank Soal</div>
                </a>
            </li>
        @endif
        @if (Auth::user()->hasAnyRole('admin', 'super-admin'))
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text" style="font-size: 15px;color: black;">LAPORAN</span>
            </li>
            <li class="menu-item {{ Request::is('*report/report-data-user-peserta*') ? 'active' : '' }}">
                <a href="/auth/report/report-data-user-peserta" class="menu-link">
                    <i class="fa-regular fa-home-alt fa-fw me-2"></i>
                    <div>Data Anggota</div>
                </a>
            </li>
        @endif --}}
    </ul>
</aside>
