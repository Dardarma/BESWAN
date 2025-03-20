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

  @yield('style')

</head>
<body>

  <nav class="navbar" style="background-color: #578FCA;">
    <a class="navbar-brand ml-4" href="#">
      <img src="{{ asset('image/Logo.png') }}" style="height: 5.3vh; width: 6.6vh" alt="">
    </a>
    
    <div class="text-end">
      <a href="{{ url('/login')}}" class="btn btn-light">Login</a>
    </div>
</nav>

<div id="carouselExampleControls" class="carousel slide" data-ride="carousel" style="max-height: 70vh">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="{{ asset('image/Acer_Wallpaper_01_5000x2814.jpg') }}" class="d-block w-100" alt="..." style="height: 70vh; object-fit: cover;">
        </div>
        <div class="carousel-item">
            <img src="{{ asset('image/Acer_Wallpaper_01_5000x2814.jpg') }}" class="d-block w-100" alt="..." style="height: 70vh; object-fit: cover;">
        </div>
        <div class="carousel-item">
            <img src="{{ asset('image/Acer_Wallpaper_01_5000x2814.jpg') }}" class="d-block w-100" alt="..." style="height: 70vh; object-fit: cover;">
        </div>
    </div>
    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>


<div class="container mt-5">

    <div class="row justify-content-center">
        @foreach ($post as $item)
        <div class="col-md-4 col-lg-4 ">
            <div class="card" style="width: 21rem;">
                <img src="{{ Storage::url($item->file_media)}}" class="card-img-top">
                <div class="card-body">
                    <h5 class="card-title"> {{$item->judul_activity}} </h5>
                    <p class="card-text">{{$item->deskripsi_activity}}.</p>
                </div>
            </div>
        </div>
        @endforeach
       
    </div>

</div>

</body>

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
<script src="https://kit.fontawesome.com/44d172af1c.js" crossorigin="anonymous"></script>


<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>


</body>
</html>
