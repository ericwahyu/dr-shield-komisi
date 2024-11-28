<!DOCTYPE html>

<html lang="id" class="light-style layout-navbar-fixed layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="{{ asset('assets/admin/') }}" data-template="vertical-menu-template-no-customizer">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- @if (Request::is('login'))
        <title>{{ env('APP_NAME') }}</title>
    @else
    @endif --}}
    <title>@yield('title') | {{ config('app.name') }}</title>

    <!-- Favicon -->
    {{-- <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/favicon/apple-touch-icon.png') }}"> --}}
    {{-- <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/favicon/Brand Logo DPA drone pilot academy-03 White 1.png') }}"> --}}
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/favicon/Brand Logo DPA drone pilot academy-03 White 1.png') }}">
    <link rel="manifest" href="{{ asset('assets/favicon/site.webmanifest') }}">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.1/css/all.css">
    <script src="https://site-assets.fontawesome.com/releases/v6.5.1/js/all.js" data-auto-add-css="false" data-auto-replace-svg="false"></script>

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/css/rtl/core.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/css/rtl/theme-default.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/demo.css') }}">

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/sweetalert2/sweetalert2.css') }}">

    <!-- Helpers -->
    <script src="{{ asset('assets/admin/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('assets/admin/js/config.js') }}"></script>

    <!-- Third Party -->
    <link rel="stylesheet" href="https://unpkg.com/tippy.js@6/dist/tippy.css">
    <script src="https://cdn.jsdelivr.net/npm/@ryangjchandler/alpine-tooltip@1.x.x/dist/cdn.min.js" defer></script>

    <!-- Custom -->
    <link rel="stylesheet" href="{{ asset('assets/admin/custom/custom.css') }}">

    {{-- favicon --}}
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/image/favicon_io/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/image/favicon_io/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/image/favicon_io/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('assets/image/favicon_io/site.webmanifest') }}">

    @yield('styles')
</head>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            @include('layouts.layout.sidebar')
            <div class="layout-page">
                @include('layouts.layout.navbar')
                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        @yield('content')
                    </div>
                    {{-- <livewire:change-password wire:model="datas"/> --}}
                    @include('layouts.layout.footer')
                    <div class="content-backdrop fade"></div>
                </div>
            </div>
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>

        <!-- Drag Target Area To SlideIn Menu On Small Screens -->
        <div class="drag-target"></div>
    </div>

    <!-- Core JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/admin/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/admin/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/admin/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/admin/vendor/js/menu.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('assets/admin/js/main.js') }}"></script>

    <!-- Third Party -->
    {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.8"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <x-livewire-alert::scripts />
    <x-livewire-alert::flash />

    <!-- Custom -->
    <script src="{{ asset('assets/admin/custom/custom-minify.js') }}"></script>

    @stack('scripts')

    <script type="text/javascript">
        function convertToRupiah(objek) {
            separator = ".";
            a = objek.value;
            b = a.replace(/[^\d]/g, "");
            c = "";
            panjang = b.length;
            j = 0;
            for (i = panjang; i > 0; i--) {
                j = j + 1;
                if (((j % 3) == 1) && (j != 1)) {
                    c = b.substr(i - 1, 1) + separator + c;
                } else {
                    c = b.substr(i - 1, 1) + c;
                }
            }
            objek.value = c;
        }
    </script>
</body>

</html>
