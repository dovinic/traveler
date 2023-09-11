<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>BromoCreative | Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('lte/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ asset('lte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('lte/dist/css/adminlte.min.css') }}">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="{{ route('login') }}" class="h1"><b>Admin</b> Bromo</a>
    </div>
    <div class="card-body">

      <form action="{{ route('login-proses') }}" method="post">
        @csrf
        @error('nama')
              <small>{{ $message }}</small>
          @enderror
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="nama" placeholder="Username">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user-tie"></span>
            </div>
          </div>
        </div>
        @error('password')
            <small>{{ $message }}</small>
        @enderror
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
            <div class="col-12">
                {!! NoCaptcha::renderJs('id', false, 'recaptchaCallback') !!}
               {!! NoCaptcha::display(['data-theme' => 'light']) !!}
               @if ($errors->has('g-recaptcha-response'))
                   <span class="help-block">
                       <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                   </span>
               @endif
            </div>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
        </div>
      </form>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{ asset('lte/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('lte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('lte/dist/js/adminlte.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if ($message = Session::get('success'))
    <script>
        Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: '{{ $message }}'
        })
    </script>
@endif

@if ($message = Session::get('failed'))
    <script>
        Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: '{{ $message }}'
        })
    </script>
@endif
</body>
</html>
