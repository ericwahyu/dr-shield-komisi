<!DOCTYPE html>
<!-- =========================================================
* sneat - Bootstrap Dashboard PRO | v2.0.0
==============================================================

* Product Page: https://themeselection.com/item/sneat-dashboard-pro-bootstrap/
* Created by: ThemeSelection
* License: You must have a valid license purchased in order to legally use the theme for your project.
* Copyright ThemeSelection (https://themeselection.com)

=========================================================
 -->
<!-- beautify ignore:start -->
<html lang = "en" class = "light-style layout-navbar-fixed layout-menu-fixed layout-compact " dir = "ltr" data-theme = "theme-default" data-assets-path = "{{ asset('assets-v2/') }}" data-template = "vertical-menu-template" data-style = "light">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">

        <title>@yield('title') | {{ config('app.name') }}</title>


        <meta name="description" content="Most Powerful &amp; Comprehensive Bootstrap 5 Admin Dashboard built for developers!">
        <meta name="keywords" content="dashboard, bootstrap 5 dashboard, bootstrap 5 design, bootstrap 5">
        <!-- Canonical SEO -->
        <link rel="canonical" href="https://themeselection.com/item/sneat-dashboard-pro-bootstrap/">


        <!-- ? PROD Only: Google Tag Manager (Default ThemeSelection: GTM-5DDHKGP, PixInvent: GTM-5J3LMKC) -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-5DDHKGP');</script>
        <!-- End Google Tag Manager -->

        <!-- Favicon -->
        <link rel="icon" type="image/x-icon" href="{{ asset('assets-v2/img/favicon/favicon.ico') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
        <link href="{{ asset('assets-v2/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap') }}" rel="stylesheet">

        <!-- Icons -->
        <!-- Icons -->
        <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.1/css/all.css">
        <script src="https://site-assets.fontawesome.com/releases/v6.5.1/js/all.js" data-auto-add-css="false" data-auto-replace-svg="false"></script>
        {{-- <link rel="stylesheet" href="{{ asset('assets-v2/admin/fonts/boxicons.css') }}">
        <link rel="stylesheet" href="{{ asset('assets-v2/admin/fonts/fontawesome.css') }}">
        <link rel="stylesheet" href="{{ asset('assets-v2/admin/fonts/flag-icons.css') }}"> --}}

        <!-- Core CSS -->
        <link rel="stylesheet" href="{{ asset('assets-v2/admin/css/rtl/core.css') }}" class="template-customizer-core-css">
        <link rel="stylesheet" href="{{ asset('assets-v2/admin/css/rtl/theme-default.css') }}" class="template-customizer-theme-css">
        <link rel="stylesheet" href="{{ asset('assets-v2/css/demo.css') }}">

        <!-- Vendors CSS -->
        <link rel="stylesheet" href="{{ asset('assets-v2/admin/libs/perfect-scrollbar/perfect-scrollbar.css') }}">
        <link rel="stylesheet" href="{{ asset('assets-v2/admin/libs/typeahead-js/typeahead.css') }}">
        <link rel="stylesheet" href="{{ asset('assets-v2/admin/libs/apex-charts/apex-charts.css') }}">

        <!-- Page CSS -->

        <!-- Helpers -->
        <script src="{{ asset('assets-v2/admin/js/helpers.js') }}"></script>
        <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
        <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
        {{-- <script src="{{ asset('assets-v2/admin/js/template-customizer.js') }}"></script> --}}
        <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
        <script src="{{ asset('assets-v2/js/config.js') }}"></script>

        <!-- Custom -->
        <link rel="stylesheet" href="{{ asset('assets-v2/admin/custom/custom.css') }}">
    </head>
    <body>
        <!-- ?PROD Only: Google Tag Manager (noscript) (Default ThemeSelection: GTM-5DDHKGP, PixInvent: GTM-5J3LMKC) -->
        <noscript>
            <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5DDHKGP" height="0" width="0" style="display: none; visibility: hidden"></iframe>
        </noscript>
        <!-- End Google Tag Manager (noscript) -->

        <!-- Layout wrapper -->
        <div class="layout-wrapper layout-content-navbar  ">
            <div class="layout-container">
                <!-- Menu -->
                @include('layouts.layout.sidebar-v2')
                <!-- / Menu -->

                <!-- Layout container -->
                <div class="layout-page">
                    <!-- Navbar -->
                    @include('layouts.layout.navbar-v2')
                    <!-- / Navbar -->
                    <!-- Content wrapper -->
                    <div class="content-wrapper">
                        <!-- Content -->
                        <div class="container-xxl flex-grow-1 container-p-y">
                            @yield('content')
                        </div>
                    </div>
                    <!-- / Content -->
                    <!-- Footer -->
                    @include('layouts.layout.footer-v2')
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                    </div>
                    <!-- Content wrapper -->
                </div>
            <!-- / Layout page -->
            </div>
            <!-- Overlay -->
            <div class="layout-overlay layout-menu-toggle">

            </div>
            <!-- Drag Target Area To SlideIn Menu On Small Screens -->
            <div class="drag-target">

            </div>

        </div>
        <!-- / Layout wrapper -->
        <!-- build:js assets/vendor/js/core.js -->

        <script src="{{ asset('assets-v2/admin/libs/jquery/jquery.js') }}"></script>
        <script src="{{ asset('assets-v2/admin/libs/popper/popper.js') }}"></script>
        <script src="{{ asset('assets-v2/admin/js/bootstrap.js') }}"></script>
        <script src="{{ asset('assets-v2/admin/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
        <script src="{{ asset('assets-v2/admin/libs/hammer/hammer.js') }}"></script>
        <script src="{{ asset('assets-v2/admin/libs/i18n/i18n.js') }}"></script>
        <script src="{{ asset('assets-v2/admin/libs/typeahead-js/typeahead.js') }}"></script>
        <script src="{{ asset('assets-v2/admin/js/menu.js') }}"></script>

        <!-- endbuild -->

        <!-- Vendors JS -->
        <script src="{{ asset('assets-v2/admin/libs/apex-charts/apexcharts.js') }}"></script>

        <!-- Main JS -->
        <script src="{{ asset('assets-v2/js/main.js') }}"></script>


        <!-- Page JS -->
        <script src="{{ asset('assets-v2/js/dashboards-analytics.js') }}"></script>

    </body>
</html>
<!-- beautify ignore:end -->

