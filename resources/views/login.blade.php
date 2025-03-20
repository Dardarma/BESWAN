<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="{{ asset('image/Logo.png') }}" type="image/png">
  <title>Beswan | Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
</head>
<body class="hold-transition login-page" style="background-color:#A1E3F9 ">
<div class="login-box">
  <div class="login-logo">
    <img src="{{asset('image/Logo.png')}}" alt="">
  </div>
  <!-- /.login-logo -->
  <div class="card border-0 shadow-none" style="background-color: #A1E3F9">
    <div class="card-body">
      <small class="mb-3">Login to your Account</small>

      <form action="{{ url('/login') }}" method="post">
        @csrf
        <div class="input-group mb-3">
          <input type="email" class="form-control border-0 shadow-sm" placeholder="Email" name="email">
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control border-0 shadow-sm" placeholder="Password" name="password">
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-block" style="background-color: #28A745; color:white">Sign In</button>
          </div>
        </div>
      </form>
    </div>
</div>


<!-- jQuery -->
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('dist/js/adminlte.min.js')}}"></script>
<!-- sweetalert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://kit.fontawesome.com/44d172af1c.js" crossorigin="anonymous"></script>
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
</body>
</html>
