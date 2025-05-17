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

        .activity-card {
            background-color: #A1E3F9;
            border-radius: 10px;
            padding: 10px;
            text-align: start;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 150px;
            width: 150px;
            justify-content: start;
            display: flex;
            flex-direction: column;
            color: #0d3f77
        }

        .activity-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .activity-icon {
            background-color: #fff;
            width: 60px;
            height: 60px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
        }

        .activity-icon i {
            font-size: 24px;
            color: #2b95c3;
        }
    </style>

</head>

<body style="padding-top:40px">
    <nav class="navbar d-flex align-items-center"
        style="background-color: #578FCA; position: fixed; top: 0; width: 100%;z-index: 100;">
        <a class="navbar-brand ml-4 d-flex align-items-center" href="#">
            <img src="{{ asset('image/Logo.png') }}" style="height: 6vh; width: 7.47vh;" alt="">
        </a>
        <div class="text-end ml-auto">
            <a href="{{ url('/login') }}" class="btn btn-light" style="color:#17A2B8; border-radius:10px">Login</a>
        </div>
    </nav>

    <div class="jumbotron jumbotron-fluid background-image d-flex align-items-center"
        style="background-image: 
            linear-gradient(rgba(87, 143, 202, 0.6), rgba(87, 143, 202, 0.6)),
            url('{{ asset('image/background.jpg') }}');
            background-size: cover; background-position: center; height: 100vh;background-attachment: fixed;">
        <div class="container" style="color: white;">
            <h1 class="display-4">THE BESWAN</h1>
            <p class="lead">IS THE MOST USUALLY</p>
            <div>
                <button class="btn btn-light">EXPLORE</button>
            </div>
        </div>
    </div>



    <div class="container mt-5">
        <div class="container">
            <div class="row">
                <div class="col-6 col-md-3 mb-4 d-flex justify-content-center">
                    <div class="activity-card">
                        <div class="activity-icon">
                            <i class="fas fa-user"></i>
                        </div>
                        <div>
                            <h5 class="mb-2">Self Improvement</h5>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-4 d-flex justify-content-center">
                    <div class="activity-card">
                        <div class="activity-icon">
                            <i class="fas fa-praying-hands"></i>
                        </div>
                        <div>
                            <h5 class="mb-2">Pray Activity</h5>
                            <p class="small mb-0">with all member</p>
                        </div>

                    </div>
                </div>
                <div class="col-6 col-md-3 mb-4 d-flex justify-content-center">
                    <div class="activity-card">
                        <div class="activity-icon">
                            <i class="fas fa-book-reader"></i>
                        </div>
                        <div>
                            <h5 class="mb-2">Learn Activity</h5>
                            <p class="small mb-0">with all member</p>
                        </div>

                    </div>
                </div>
                <div class="col-6 col-md-3 mb-4 d-flex justify-content-center">
                    <div class="activity-card">
                        <div class="activity-icon">
                            <i class="far fa-calendar-alt"></i>
                        </div>
                        <div>
                            <h5 class="mb-2">Time Management</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container my-5 mx-auto">
        <div class="row">
            <div class="col-12 col-md-6">
                <img src="{{ url(asset('image/Besawn Art 1.png')) }}" style="width: 90%; height:auto">
            </div>
            <div class="col-12 col-md-6">
            </div>
            <div class="col-12 col-md-6">
            </div>
            <div class="col-12 col-md-6">
                <img src="{{ url(asset('image/Besawn Art 2.png')) }}" style="width: 90%; height:auto">
            </div>
        </div>
    </div>

</body>

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
<script src="https://kit.fontawesome.com/44d172af1c.js" crossorigin="anonymous"></script>


<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>


</body>

</html>
