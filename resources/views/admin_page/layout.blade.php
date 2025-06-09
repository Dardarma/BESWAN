<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('image/Logo.png') }}" type="image/png">


    <title>Beswan E-learning </title>

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

</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{ asset('image/Logo.png') }}" alt="AdminLTELogo" height="60"
                width="60">
        </div>

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light"
            style="background-color: #4d90fe; align-items: center;">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"
                            style="color: #ffffff;"></i></a>
                </li>
                <li class="nav-item" style="display: flex; align-items: center; margin-left: 10px;">
                    <span class="badge badge-pill"
                        style="
                background-color: #ffffff;
                color: #4d90fe;
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
                background-color: #4d90fe;
                border-radius: 50%;
                margin-right: 5px;
            "></span>
                        {{ Auth::user()->role }}
                    </span>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li>
                    <a href="{{ url('admin/profile') }}">
                        <img src="{{ Auth::user()->foto_profil && Storage::exists(Auth::user()->foto_profil) ? Storage::url(Auth::user()->foto_profil) : asset('image/Avatar.png') }}"
                            alt="Foto Profil" class="rounded-circle" width="40" height="40"
                            style="border: 2px solid #ffffff;">
                    </a>
                </li>
                <li>
                    <a class="nav-link" href="{{ url('admin/profile') }}" style="color: #ffffff;">
                        {{ Auth::user()->name }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt" style="color: #ffffff;"></i>
                    </a>
                </li>
                {{-- <li class="nav-item">
          <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#" role="button">
              <i class="fas fa-th-large" style="color: #ffffff;"></i>
          </a>
      </li> --}}

            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
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
                                <a href="{{ url('/admin/home') }}" class="nav-link"
                                    style="{{ request()->is('admin/home') ? 'background-color: #E0F2FE; color: #000000; border-radius: 10px;' : 'background-color: #005FC3; color: #ffff; border-radius: 10px;' }}">
                                    <img src="{{ request()->is('admin/home') ? asset('icon/Hitam/Home Hitam.svg') : asset('icon/Putih/Home Putih.svg') }}"
                                        style="width: 20px; height: 20px; margin-right: 10px;">
                                    <p
                                        style="{{ request()->is('admin/home') ? 'color: #000000;' : 'color: #ffffff;' }}">
                                        Home
                                    </p>
                                </a>
                            </li>

                            {{-- profile --}}
                            <li class="nav-item">
                                <a href="{{ url('/admin/profile') }}" class="nav-link"
                                    style="{{ request()->is('admin/profile') ? 'background-color: #E0F2FE; color: #000000; border-radius: 10px;' : 'background-color: #005FC3; color: #ffff; border-radius: 10px;' }}">
                                    <img src="{{ request()->is('admin/profile') ? asset('icon/Hitam/Profil Hitam.svg') : asset('icon/Putih/Profil Putih.svg') }}"
                                        style="width: 20px; height: 20px; margin-right: 10px;">
                                    <p
                                        style="{{ request()->is('admin/profile') ? 'color: #000000;' : 'color: #ffffff;' }}">
                                        Profile
                                    </p>
                                </a>
                            </li>
                            <!-- Master -->
                            @if (Auth::user()->role == 'superadmin')
                                <li class="nav-item menu-open my-2"
                                    style="background-color: #005FC3; color: #ffffff; border-radius: 10px;">
                                    <a href="#" class="nav-link">
                                        <img src="{{ asset('icon/Putih/Master Putih.svg') }}"
                                            style="width: 20px; height: 20px; margin-right: 10px;">
                                        <p style="color: #ffffff;' : 'color: #111010;">
                                            Master
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <!-- Submenu -->
                                    <ul class="nav nav-treeview">
                                        <!-- User -->
                                        <li class="nav-item">
                                            <a href="{{ url('/admin/master/user') }}" class="nav-link"
                                                style="{{ request()->is('admin/master/user/*') || request()->is('admin/master/user') ? 'background-color: #E0F2FE; color: #000000; border-radius: 10px;' : 'background-color: #005FC3; color: #ffff; ' }}">
                                                <img src="{{ request()->is('admin/master/user/*') || request()->is('admin/master/user') ? asset('icon/Hitam/User Hitam.svg') : asset('icon/Putih/User Putih.svg') }}"
                                                    style="width: 20px; height: 20px; margin-right: 10px;">
                                                <p
                                                    style="{{ request()->is('admin/master/user/*') || request()->is('admin/master/user') ? 'color: #000000;' : 'color: #fffff;' }}">
                                                    User</p>
                                            </a>
                                        </li>
                                        <!-- Level -->
                                        <li class="nav-item">
                                            <a href="{{ url('/admin/master/level/user') }}" class="nav-link"
                                                style="{{ request()->is('admin/master/level/*') ? 'background-color: #E0F2FE; color: #000000; border-radius: 10px;' : 'background-color: #005FC3; color: #ffff; ' }}">
                                                <img src="{{ request()->is('admin/master/level/*') ? asset('icon/Hitam/Level Hitam.svg') : asset('icon/Putih/Level Putih.svg') }}"
                                                    style="width: 20px; height: 20px; margin-right: 10px;">
                                                <p
                                                    style="{{ request()->is('admin/master/level/*') ? 'color: #000000;' : 'color: #ffffff;' }}">
                                                    Level</p>
                                            </a>
                                        </li>
                                        <!-- List Aktivitas -->
                                        <li class="nav-item my-2">
                                            <a href="{{ url('/admin/master/daily_activity') }}" class="nav-link"
                                                style="{{ request()->is('admin/master/daily_activity') ? 'background-color: #E0F2FE; color: #000000; border-radius: 10px;' : 'background-color: #005FC3; color: #ffff; ' }}">
                                                <img src="{{ request()->is('admin/master/daily_activity') ? asset('icon/Hitam/Daily Actv Hitam.svg') : asset('icon/Putih/Daily Actv Putih.svg') }}"/>
                                                    <p
                                                    style="{{ request()->is('admin/master/daily_activity') ? 'color: #000000;' : 'color: #ffffff;' }}">
                                                Activity List</p>
                                            </a>
                                        </li>

                                        <li class="nav-item my-2">
                                            <a href="{{ url('/admin/master/feed') }}" class="nav-link"
                                                style="{{ request()->is('admin/master/feed') || request()->is('admin/master/feed*') ? 'background-color: #E0F2FE; color: #000000; border-radius: 10px;' : 'background-color: #005FC3; color: #ffff; ' }}">
                                                <img src="{{ request()->is('admin/master/feed') || request()->is('admin/master/feed*') ? asset('icon/Hitam/Gallery Hitam.svg') : asset('icon/Putih/Gallery Putih.svg') }}"
                                                    style="width: 20px; height: 20px; margin-right: 10px;">
                                                <p
                                                    style="{{ request()->is('admin/master/feed') || request()->is('admin/master/feed*') ? 'color: #000000;' : 'color: #ffffff;' }}">
                                                    Galeri
                                                </p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @endif





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
                                        <a href="{{ url('/admin/article') }}" class="nav-link"
                                            style="{{ request()->is('admin/article') || request()->is('admin/article/*') ? 'background-color: #E0F2FE; color: #000000; border-radius: 10px;' : 'background-color: #005FC3; color: #ffff; ' }}">
                                            <img src="{{ request()->is('admin/article') || request()->is('admin/article/*') ? asset('icon/Hitam/Materi Hitam.svg') : asset('icon/Putih/Materi Putih.svg') }}"
                                                style="width: 20px; height: 20px; margin-right: 10px;">
                                            <p
                                                style="{{ request()->is('admin/article') || request()->is('admin/article/*') ? 'color: #000000;' : 'color: #ffffff;' }}">
                                                Materi
                                            </p>
                                        </a>
                                    </li>
                                    <!-- Video -->
                                    <li class="nav-item">
                                        <a href="{{ url('/admin/video') }}" class="nav-link"
                                            style="{{ request()->is('admin/video') || request()->is('admin/video/*') ? 'background-color: #E0F2FE; color: #000000; border-radius: 10px;' : 'background-color: #005FC3; color: #ffff; ' }}">
                                            <img src="{{ request()->is('admin/video') || request()->is('admin/video/*') ? asset('icon/Hitam/Video Hitam.svg') : asset('icon/Putih/Video Putih.svg') }}"
                                                style="width: 20px; height: 20px; margin-right: 10px;">
                                            <p
                                                style="{{ request()->is('admin/video') || request()->is('admin/video/*') ? 'color: #000000;' : 'color: #ffffff;' }}">
                                                Video
                                            </p>
                                        </a>
                                    </li>

                                </ul>
                            </li>



                            <li class="nav-item">
                                <a href="{{ url('/admin/module') }}" class="nav-link"
                                    style="{{ request()->is('admin/module') || request()->is('admin/module/*') ? 'background-color: #E0F2FE; color: #000000; border-radius: 10px;' : 'background-color: #005FC3; color: #ffff; border-radius: 10px;' }}">
                                    <img src="{{ request()->is('admin/module') || request()->is('admin/module/*') ? asset('icon/Hitam/E Book Hitam.svg') : asset('icon/Putih/E Book Putih.svg') }}"
                                        style="width: 20px; height: 20px; margin-right: 10px;">
                                    <p
                                        style="{{ request()->is('admin/module') || request()->is('admin/module/*') ? 'color: #000000;' : 'color: #ffffff;' }}">
                                        E-book
                                    </p>
                                </a>
                            </li>

                            <li class="nav-item menu-open my-2"
                                style="background-color: #005FC3; color: #ffffff; border-radius: 10px;">
                                <a href="#" class="nav-link">
                                    <img src=" {{ asset('icon/Putih/Quiz Putih.svg') }}"
                                        style="width: 20px; height: 20px; margin-right: 10px;">
                                    <p style="color: #ffffff;">
                                        Quiz
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <!-- Submenu -->
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ url('/admin/quiz') }}" class="nav-link"
                                            style="{{ request()->is('admin/quiz') || request()->is('admin/quiz/*') ? 'background-color: #E0F2FE; color: #000000; border-radius: 10px;' : 'background-color: #005FC3; color: #ffff; ' }}">
                                            <img src="{{ request()->is('admin/quiz') || request()->is('admin/quiz/*') ? asset('icon/Hitam/Quiz Hitam.svg') : asset('icon/Putih/Quiz Putih.svg') }}"
                                                style="width: 20px; height: 20px; margin-right: 10px;">
                                            <p
                                                style="{{ request()->is('admin/quiz') || request()->is('admin/quiz/*') ? 'color: #000000;' : 'color: #ffffff;' }}">
                                                Quiz
                                            </p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{ url('admin/quiz_report') }}" class="nav-link"
                                            style="{{ request()->is('admin/quiz_report') || request()->is('admin/quiz_report/*') ? 'background-color: #E0F2FE; color: #000000; border-radius: 10px;' : 'background-color: #005FC3; color: #ffff; ' }}">
                                            <img src="{{ request()->is('admin/quiz_report') || request()->is('admin/quiz_report/*') ? asset('icon\Hitam\Report Nilai Hitam.svg') : asset('icon\Putih\Report Quiz Putih.svg') }}"
                                                style="width: 20px; height: 20px; margin-right: 10px;">
                                            <p
                                                style="{{ request()->is('admin/quiz_report') || request()->is('admin/quiz_report/*') ? 'color: #000000;' : 'color: #ffffff;' }}">
                                                Quiz Report
                                            </p>
                                        </a>
                                    </li>

                                </ul>
                            </li>


                            <li class="nav-item">
                                <a href="{{ url('/admin/user_activity') }}" class="nav-link"
                                    style="{{ request()->is('admin/user_activity') || request()->is('admin/user_activity/*') ? 'background-color: #E0F2FE; color: #000000; border-radius: 10px;' : 'background-color: #005FC3; color: #ffff; border-radius: 10px;' }}">
                                    <img src="{{ request()->is('admin/user_activity') || request()->is('admin/user_activity/*') ? asset('icon/Hitam/Report Actv Hitam.svg') : asset('icon/Putih/Report Actv Putih.svg') }}"
                                        style="width: 20px; height: 20px; margin-right: 10px;">
                                    <p
                                        style="{{ request()->is('admin/user_activity') || request()->is('admin/user_activity/*') ? 'color: #000000;' : 'color: #ffffff;' }}">
                                        Repot User Activity
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


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
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
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

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
