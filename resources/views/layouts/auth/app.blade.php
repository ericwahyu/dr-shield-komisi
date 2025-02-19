<!doctype html>
<html lang="id">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ env('APP_NAME') }}</title>
    <!-- FAVICON -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('assets/favicon/site.webmanifest') }}">
    <!-- FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://acchou.github.io/html-css-cheat-sheet/animate.css">
    <!-- Icons -->
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/all.css">
    <!-- Script in Styles -->
    {{-- favicon --}}
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/image/favicon_io/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/image/favicon_io/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/image/favicon_io/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('assets/image/favicon_io/site.webmanifest') }}">

    <script src="https://site-assets.fontawesome.com/releases/v6.4.0/js/all.js" data-auto-add-css="false" data-auto-replace-svg="false"></script>
    <script src="https://cdn.jsdelivr.net/npm/@ryangjchandler/alpine-tooltip@1.x.x/dist/cdn.min.js" defer></script>
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        .bg-auth {
            background: url('/assets/image/central-park.webp');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
            background-position: center center;
        }

        .card {
            position: relative;
            width: 500px;
            /* height: 750px; */
            background: transparent;
            border: 2px solid rgba(255, 255, 255, .5);
            border-radius: 20px;
            backdrop-filter: blur(50px);
            box-shadow: 0 0 30px rgba(0, 0, 0, .5);
            /* overflow: hidden; */
        }

        .input-box {
            position: relative;
            width: 100%;
            height: 50px;
            border-bottom: 2px solid white;
            margin-top: 3px;
            margin-bottom: 03px;
        }
        select {
            background-color: transparent;
            /* position: relative; */
            width: 93%;
            height: 50px;
            color: #FFFFFF;
            /* border-bottom: 2px solid white; */
            border: none;
            margin-top: 3px;
            margin-bottom: 3px;
        }

        .input-box label {
            position: absolute;
            top: 50%;
            left: 0;
            transform: translateY(-50%);
            font-size: 1em;
            color: white;
            font-weight: 500;
            pointer-events: none;
            transition: .5s;
        }

        .input-box input:focus~label,
        .input-box input:valid~label {
            top: -5px;
        }

        .input-box input {
            width: 100%;
            height: 100%;
            background: transparent;
            border: none;
            outline: none;
            color: white;
            padding: 0 67px 0 0;
        }

        .input-box .icon {
            position: absolute;
            right: 8px;
            font-size: 1.2em;
            color: white;
            line-height: 57px;
        }

        .animated {
            animation-duration: .5s;
        }

        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, #025490 28.43%, #FFCA0A 28.44%, #FFCA0A 71.15%, #E71B24 71.16%);
        }

        .text-danger {
            color: #b80008 !important;
        }

        .form-label {
            font-weight: 500;
        }

        .invalid-feedback {
            color: #b80008 !important;
        }

        .loading-screen {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            width: 100%;
            height: 100%;
            z-index: 1081;
            overflow: hidden;
            background-color: #FFFFFF;
            opacity: 0.75;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .cursor-pointer {
            cursor: pointer;
        }

        ::placeholder {
            color: #FFFFFF;
        }

        input:focus::placeholder {
            color: transparent;
        }
    </style>
    @yield('styles')
</head>

<body>
    @yield('content')

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <x-livewire-alert::scripts />
    <x-livewire-alert::flash />
    @stack('scripts')
</body>

</html>
