<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="icon" href="{{ asset('image/Logo.png') }}" type="image/png">


  <title>Beswan |  </title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{asset('plugins/jqvmap/jqvmap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{asset('plugins/daterangepicker/daterangepicker.css')}}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{asset('plugins/summernote/summernote-bs4.min.css')}}">

  <script src="https://cdn.tiny.cloud/1/563p8m02hict3s1hgthnyqvcm5uyvuk92tcq59jl6ind0ujf/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
  @yield('style')

</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{ asset('image/Logo.png') }}" alt="AdminLTELogo" height="60" width="60">
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <form action="{{ url('/logout') }}" method="post">
          @csrf
          <button type="submit" class="btn btn-light" style="background-color: #09bbf6; color:rgb(252, 252, 252)">Logout</button>
        </form>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-light-primary elevation-4" style="background-color: #A1E3F9;">
    <!-- Brand Logo -->
    <div class="brand-link d-flex justify-content-center">
      <img src="{{ asset('image/Logo.png') }}" style="height: 10.6vh; width: 13.2vh" alt="">
    </div>  
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
       
        <div class="info">
          <a href="#" class="d-block"> {{auth()->user()->name}} </a>
        </div>
      </div>

      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item menu-open">
            <a href="#" class="nav-link {{ request()->is('master/*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Master
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{url('/master/user')}}" class="nav-link {{ request()->is('master/user/*') || request()->is('master/user') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>User</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('/master/level/user') }}" class="nav-link {{ request()->is('master/level/*') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Level</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('/master/daily_activity') }}" class="nav-link {{ request()->is('master/daily_activity') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>List Aktivitas</p>
                </a>
              </li>
              
            </ul>
          </li>
          <li>
            <a href="{{ url('/article')}}" class="nav-link {{ request()->is('article') || request()->is('article/*') ? 'active' : '' }}">
              <i class="fa-solid fa-newspaper"></i>
              <p>
                 Materi
              </p>
            </a>
          </li>
          <li>
            <a href="{{ url('/module')}}" class="nav-link {{ request()->is('module') || request()->is('module/*') ? 'active' : '' }}">
              <i class="fa-solid fa-book"></i>
              <p>
                 E-book
              </p>
            </a>
          </li>
          <li>
            <a href="{{ url('/feed')}}" class="nav-link {{ request()->is('feed') || request()->is('feed/*') ? 'active' : '' }}">
              <i class="fa-regular fa-image"></i>
              <p>
                 Activity Feed
              </p>
            </a>
          </li>
          <li>
            <a href="{{ url('/user_activity')}}" class="nav-link {{ request()->is('/user_activity') || request()->is('user_activity/*') ? 'active' : '' }}">
              <i class="fa-solid fa-list-check"></i>
              <p>
                  Repot User Activity
              </p>
            </a>
          </li>
          <li class="nav-item">
            <li>
              <a href="{{ url('/quiz')}}" class="nav-link">
                <i class="fa-solid fa-list-check"></i>
                <p>
                    Quiz
                </p>
              </a>
            </li>
            <li class="nav-item">
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
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
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- ChartJS -->
<script src="{{asset('plugins/chart.js/Chart.min.js')}}"></script>
<!-- Sparkline -->
<script src="{{asset('plugins/sparklines/sparkline.js')}}"></script>
<!-- JQVMap -->
<script src="{{asset('plugins/jqvmap/jquery.vmap.min.js')}}"></script>
<script src="{{asset('plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
<!-- jQuery Knob Chart -->
<script src="{{asset('plugins/jquery-knob/jquery.knob.min.js')}}"></script>
<!-- daterangepicker -->
<script src="{{asset('plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('plugins/daterangepicker/daterangepicker.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<!-- Summernote -->
<script src="{{asset('plugins/summernote/summernote-bs4.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('dist/js/adminlte.js')}}"></script>
<!-- sweetalert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://kit.fontawesome.com/44d172af1c.js" crossorigin="anonymous"></script>


<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
@yield('script')


</body>
</html>
