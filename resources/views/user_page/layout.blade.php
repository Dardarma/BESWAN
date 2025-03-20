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
<body class="hold-transition sidebar-mini layout-fixed" style="background: #fff">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{ asset('image/Logo.png') }}" alt="AdminLTELogo" height="60" width="60">
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light" style="background-color: #4d90fe; align-items: center;">
      <!-- Left navbar links -->
      <ul class="navbar-nav" style="display: flex; align-items: center;">
          <!-- Pushmenu Icon -->
          <li class="nav-item">
              <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                  <i class="fas fa-bars" style="color: #ffffff;"></i>
              </a>
          </li>

          <!-- Badge Elementary -->
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
                  <span style="
                      width: 10px;
                      height: 10px;
                      background-color: #4d90fe;
                      border-radius: 50%;
                      margin-right: 5px;
                  "></span>
                  Elementary
              </span>
          </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto" style="display: flex; align-items: center;">
          <!-- Fullscreen Icon -->
          <li class="nav-item">
              <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                  <i class="fas fa-expand-arrows-alt" style="color: #ffffff;"></i>
              </a>
          </li>

          <!-- Control Sidebar Icon -->
          <li class="nav-item">
              <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#" role="button">
                  <i class="fas fa-th-large" style="color: #ffffff;"></i>
              </a>
          </li>

          <!-- Logout Button -->
          <li class="nav-item d-none d-sm-inline-block">
              <form action="{{ url('/logout') }}" method="post">
                  @csrf
                  <button type="submit" class="btn btn-light" 
                      style="
                          background-color: #09bbf6;
                          color: #ffffff;
                          border-radius: 20px;
                          padding: 5px 15px;
                          font-size: 14px;
                      ">
                      Logout
                  </button>
              </form>
          </li>
      </ul>
  </nav>


  <aside class="main-sidebar elevation-4" style="background-color: #A1E3F9; color: #fff;">
    <div class="brand-link d-flex justify-content-center">
      <img src="{{ asset('image/Logo.png') }}" style="height: 10.6vh; width: 13.2vh" alt="">
    </div>  
    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
        </div>
      </div>
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item menu-open" style="{{ request()->is('user/level-chose') ? 'background-color: #578FCA; border-radius: 20px;' : '' }}">
                <a href="#" class="nav-link " style="{{ request()->is('user/level-chose') ? 'color: #ffffff;' : 'color: #111010;' }}">
                    <img src="{{asset ('icon\Home.svg')}}" alt="" style="width: 24px; height: 24px; margin-right: 10px;">
                    <p>
                        Home
                    </p>
                </a>
            </li>
            <li class="nav-item menu-open" style="{{ request()->is('') ? 'background-color: #578FCA; border-radius: 20px;' : '' }}">
              <a href="#" class="nav-link " 
                  style="{{ request()->is('') ? 'color: #ffffff;' : 'color: #111010;' }}">
                  <img src="{{asset ('icon\Profile.svg')}}" alt="" style="width: 24px; height: 24px; margin-right: 10px;">
                  <p>
                      Profile
                  </p>
              </a>
          </li>
          <li class="nav-item menu-open" style="{{ request()->is('') ? 'background-color: #578FCA; border-radius: 20px;' : '' }}">
            <a href="#" class="nav-link " 
                style="{{ request()->is('') ? 'color: #ffffff;' : 'color: #111010;' }}">
                <img src="{{asset ('icon\Materi.svg')}}" alt="" style="width: 24px; height: 24px; margin-right: 10px;">
                <p>
                    Materi
                </p>
            </a>
          </li>
          <li class="nav-item menu-open" style="{{ request()->is('') ? 'background-color: #578FCA; border-radius: 20px;' : '' }}">
            <a href="#" class="nav-link " 
                style="{{ request()->is('') ? 'color: #ffffff;' : 'color: #111010;' }}">
                <img src="{{asset ('icon\Video.svg')}}" alt="" style="width: 24px; height: 24px; margin-right: 10px;">
                <p>
                   Video
                </p>
            </a>
          </li>
          <li class="nav-item menu-open" style="{{ request()->is('') ? 'background-color: #578FCA; border-radius: 20px;' : '' }}">
            <a href="#" class="nav-link " 
                style="{{ request()->is('') ? 'color: #ffffff;' : 'color: #111010;' }}">
                <img src="{{asset ('icon\E Book.svg')}}" alt="" style="width: 24px; height: 24px; margin-right: 10px;">
                <p>
                   E-book
                </p>
            </a>
          </li>
          <li class="nav-item menu-open" style="{{ request()->is('') ? 'background-color: #578FCA; border-radius: 20px;' : '' }}">
            <a href="#" class="nav-link " 
                style="{{ request()->is('') ? 'color: #ffffff;' : 'color: #111010;' }}">
                <img src="{{asset ('icon\Quiz.svg')}}" alt="" style="width: 24px; height: 24px; margin-right: 10px;">
                <p>
                   Quiz
                </p>
            </a>
          </li>
        </ul>
    </nav>    
    </div>
  </aside>

  <div class="content-wrapper" style="background-color: #fff">
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
