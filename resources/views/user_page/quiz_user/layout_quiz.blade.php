<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('image/Logo.png') }}" type="image/png">


    <title>Beswan | </title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('plugins/jqvmap/jqvmap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}">

    <script src="https://cdn.tiny.cloud/1/563p8m02hict3s1hgthnyqvcm5uyvuk92tcq59jl6ind0ujf/tinymce/7/tinymce.min.js"
        referrerpolicy="origin"></script>

    @yield('style')

    <style>
        body {
            position: relative;
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }

        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('{{ asset('image/background.jpg') }}');
            background-size: cover;
            background-position: center;
            opacity: 0.1;
            z-index: -1;
        }
    </style>

</head>

<body class=" hold-transition layout-top-nav" style="">

    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__shake" src="{{ asset('image/Logo.png') }}" alt="AdminLTELogo" height="60"
            width="60">
    </div>

    <!-- Navbar -->
    <nav
        class="main-header navbar navbar-expand navbar-white navbar-light "style="background-color: #4d90fe; align-items: center;">
        <!-- Left navbar links -->
        <ul class="navbar-nav" style="display: flex; align-items: center;">
            <!-- Badge Elementary -->
            @php
                $user = Auth::user();
                $levelTerakhir = null;

                if ($user && $user->role === 'user' && $user->levels->isNotEmpty()) {
                    $levelTerakhir = $user->levels->sortByDesc('level_urutan')->last();
                    $warna = $levelTerakhir->warna ?? '#4d90fe'; // fallback warna default
                } else {
                    $warna = '#4d90fe';
                }
            @endphp

            <li class="nav-item" style="display: flex; align-items: center; margin-left: 10px; ">
                <span class="badge badge-pill"
                    style="
                    background-color: #ffffff;
                    color: {{ $warna }};
                    padding: 5px 10px;
                    font-size: 14px;
                    display: flex;
                    align-items: center;
                    border-radius: 20px;
                    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
                ">
                    <span
                        style="
                    width: 10px;
                    height: 10px;
                    background-color: {{ $warna }};
                    border-radius: 50%;
                    margin-right: 5px;
                "></span>

                    @if ($user->role === 'user')
                        {{ $levelTerakhir ? $levelTerakhir->nama_level : 'No Level' }}
                    @else
                        {{ ucfirst($user->role) }}
                    @endif
                </span>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto" style="display: flex; align-items: center;">
            <li>
                <img src="{{ Auth::user()->foto_profil ? Storage::url(Auth::user()->foto_profil) : asset('images/Avatar.png') }}"
                    alt="Foto Profil" class="rounded-circle" width="40" height="40"
                    style=" border: 2px solid #ffffff;">
            </li>
            <li>
                <a class="nav-link" href="#" style="color: #ffffff;">
                    {{ Auth::user()->name }}
                </a>
            </li>
            <!-- Fullscreen Icon -->
            <li class="nav-item">
                <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt" style="color: #ffffff;"></i>
                </a>
            </li>

        </ul>
    </nav>



    <div class="content-wrapper" style="background-color: transparent !important;">
        @if ($errors->any())
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        html: `<ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>`,
                        confirmButtonText: 'OK',
                    });
                });
            </script>
        @endif

        @if (session('success'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: '{{ session('success') }}',
                        confirmButtonText: 'OK',
                    });
                });
            </script>
        @endif

        @if (session('error'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Warning!',
                        text: '{{ session('error') }}',
                        confirmButtonText: 'OK',
                    });
                });
            </script>
        @endif

        

        @yield('content')

    </div>

    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.js') }}"></script>
    <!-- sweetalert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://kit.fontawesome.com/44d172af1c.js" crossorigin="anonymous"></script>


    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    @yield('script')


</body>

</html>
