<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('image/Logo.png') }}" type="image/png">


    <title>Beswan E-learning</title>

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

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed; padding-top:40px;" style="">
    <div class="wrapper">

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
                <!-- Pushmenu Icon -->
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                        <i class="fas fa-bars" style="color: #ffffff;"></i>
                    </a>
                </li>

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
                    box-shadow: 0 2px 4px rgba(0,0,0,0.2);">
                        <span
                            style="
                    width: 10px;
                    height: 10px;
                    background-color: {{ $warna }};
                    border-radius: 50%;
                    margin-right: 5px;">
                        </span>

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


        <aside class="main-sidebar elevation-4" style="background-color: #38BDF8; color: #ffff;">
            <!-- Brand Logo -->
            <div class="brand-link d-flex justify-content-center">
                <img src="{{ asset('image/Logo.png') }}" style="height: 10.6vh; width: 13.2vh" alt="">
            </div>

            <!-- Sidebar -->
            <div class="sidebar">

                <!-- Sidebar Menu - Scrollable Area -->
                <div style="height: calc(100vh - 200px); overflow-y: auto; overflow-x: hidden; margin-bottom: 10px;">
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                            data-accordion="false">




                            <li class="nav-item">
                                <a href="{{ url('/user/home') }}" class="nav-link"
                                    style="{{ request()->is('user/home') ? 'background-color: #E0F2FE; color: #000000; border-radius: 10px;' : 'background-color: #005FC3; color: #ffff; border-radius: 10px;' }}">
                                    <img src="{{ request()->is('user/home') ? asset('icon/Hitam/Home Hitam.svg') : asset('icon/Putih/Home Putih.svg') }}"
                                        style="width: 20px; height: 20px; margin-right: 10px;">
                                    <p
                                        style="{{ request()->is('user/home') ? 'color: #000000;' : 'color: #ffffff;' }}">
                                        Home
                                    </p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ url('/user/profile') }}" class="nav-link"
                                    style="{{ request()->is('user/profile') ? 'background-color: #E0F2FE; color: #000000; border-radius: 10px;' : 'background-color: #005FC3; color: #ffff; border-radius: 10px;' }}">
                                    <img src="{{ request()->is('user/profile') ? asset('icon/Hitam/Profil Hitam.svg') : asset('icon/Putih/Profil Putih.svg') }}"
                                        style="width: 20px; height: 20px; margin-right: 10px;">
                                    <p
                                        style="{{ request()->is('user/profile') ? 'color: #000000;' : 'color: #ffffff;' }}">
                                        Profile
                                    </p>
                                </a>
                            </li>



                            <!-- Materi -->
                            <li class="nav-item menu-open my-2"
                                style="background-color: #005FC3; color: #ffffff; border-radius: 10px;">
                                <a href="#" class="nav-link">
                                    <img src="{{ asset('icon/Putih/Materi Putih.svg') }}"
                                        style="width: 20px; height: 20px; margin-right: 10px;">
                                    <p style="color: #ffffff;">
                                        Materi
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <!-- Submenu -->
                                <ul class="nav nav-treeview">
                                    <!-- Materi-->
                                    <li class="nav-item">
                                        <a href="{{ url('/user/materi') }}" class="nav-link"
                                            style="{{ request()->is('user/materi') || request()->is('user/materi/*') ? 'background-color: #E0F2FE; color: #000000; border-radius: 10px;' : 'background-color: #005FC3; color: #ffff; ' }}">
                                            <img src="{{ request()->is('user/materi') || request()->is('user/materi/*') ? asset('icon/Hitam/Materi Hitam.svg') : asset('icon/Putih/Materi Putih.svg') }}"
                                                style="width: 20px; height: 20px; margin-right: 10px;">
                                            <p
                                                style="{{ request()->is('user/materi') || request()->is('user/materi/*') ? 'color: #000000;' : 'color: #ffffff;' }}">
                                                Materi
                                            </p>
                                        </a>
                                    </li>
                                    <!-- Video -->
                                    <li class="nav-item">
                                        <a href="{{ url('/user/video') }}" class="nav-link"
                                            style="{{ request()->is('user/video') || request()->is('user/video/*') ? 'background-color: #E0F2FE; color: #000000; border-radius: 10px;' : 'background-color: #005FC3; color: #ffff; ' }}">
                                            <img src="{{ request()->is('user/video') || request()->is('user/video/*') ? asset('icon/Hitam/Video Hitam.svg') : asset('icon/Putih/Video Putih.svg') }}"
                                                style="width: 20px; height: 20px; margin-right: 10px;">
                                            <p
                                                style="{{ request()->is('user/video') || request()->is('user/video/*') ? 'color: #000000;' : 'color: #ffffff;' }}">
                                                Video
                                            </p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('/user/ebook') }}" class="nav-link"
                                    style="{{ request()->is('user/ebook') || request()->is('user/ebook*') ? 'background-color: #E0F2FE; color: #000000; border-radius: 10px;' : 'background-color: #005FC3; color: #ffff; border-radius: 10px;' }}">
                                    <img src="{{ request()->is('user/ebook') || request()->is('user/ebook/*') ? asset('icon/Hitam/E Book Hitam.svg') : asset('icon/Putih/E Book Putih.svg') }}"
                                        style="width: 20px; height: 20px; margin-right: 10px;">
                                    <p
                                        style="{{ request()->is('user/ebook') || request()->is('user/ebook/*') ? 'color: #000000;' : 'color: #ffffff;' }}">
                                        E-book
                                    </p>
                                </a>
                            </li>


                            <li class="nav-item">
                                <a href=" {{ url('/user/daily_activity') }} " class="nav-link"
                                    style="{{ request()->is('user/daily_activity') || request()->is('user/daily_activity/*') ? 'background-color: #E0F2FE; color: #000000; border-radius: 10px;' : 'background-color: #005FC3; color: #ffff; border-radius: 10px;' }}">
                                    <img src="{{ request()->is('user/daily_activity') || request()->is('user/daily_activity/*') ? asset('icon/Hitam/Daily Actv Hitam.svg') : asset('icon/Putih/Daily Actv Putih.svg') }}"
                                        style="width: 20px; height: 20px; margin-right: 10px;">
                                    <p
                                        style="{{ request()->is('user/daily_activity') || request()->is('user/daily_activity/*') ? 'color: #000000;' : 'color: #ffffff;' }}">
                                        Daily Activity
                                    </p>
                                </a>
                            </li>


                            <li class="nav-item">
                                <a href="{{ url('user/quiz') }}" class="nav-link"
                                    style="{{ request()->is('user/quiz') || request()->is('user/quiz/*') ? 'background-color: #E0F2FE; color: #000000; border-radius: 10px;' : 'background-color: #005FC3; color: #ffff; border-radius: 10px;' }}">
                                    <img src="{{ request()->is('user/quiz') || request()->is('user/quiz/*') ? asset('icon/Hitam/Quiz Hitam.svg') : asset('icon/Putih/Quiz Putih.svg') }}"
                                        style="width: 20px; height: 20px; margin-right: 10px;">
                                    <p
                                        style="{{ request()->is('user/quiz') || request()->is('user/quiz/*') ? 'color: #000000;' : 'color: #ffffff;' }}">
                                        Quiz
                                    </p>
                                </a>
                            </li>


                        </ul>
                    </nav>
                </div>
            </div>

            <!-- Fixed Logout Button -->
            <div style="position: fixed; bottom: 0; width: inherit; background-color: #38BDF8; padding: 10px 15px;">
                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                <a href="#" class="nav-link"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    style="background-color: #38BDF8; border-radius: 20px; border: none; width: 100%; text-align: left; padding: 12px;">
                    <i class="fa-solid fa-right-from-bracket" style="color: #ffffff; font-size: 1.5rem;"></i>
                    <span style="color: #ffffff; font-size: 1.5rem; font-weight: 600;">Logout</span>
                </a>
            </div>

        </aside>

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

        <aside class="control-sidebar control-sidebar-dark">
        </aside>
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
    <!-- ChartJS -->
    <script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
    <!-- Sparkline -->
    <script src="{{ asset('plugins/sparklines/sparkline.js') }}"></script>
    <!-- JQVMap -->
    <script src="{{ asset('plugins/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{ asset('plugins/jquery-knob/jquery.knob.min.js') }}"></script>
    <!-- daterangepicker -->
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <!-- Summernote -->
    <script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.js') }}"></script>
    <!-- sweetalert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://kit.fontawesome.com/44d172af1c.js" crossorigin="anonymous"></script>


    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    @yield('script')


</body>

</html>
