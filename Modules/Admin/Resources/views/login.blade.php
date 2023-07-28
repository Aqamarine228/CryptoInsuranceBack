<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ Module::asset('admin:plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ Module::asset('admin:css/adminlte.min.css') }}">
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <a href="#" class="h1"><b>Insurance</b> Admin</a>
            @php
                use Modules\Admin\Components\SessionAlerts;
                $alert = new SessionAlerts();
            @endphp

            @if($alert->hasError())
                <p class="bg-red rounded">
                    {{ $alert->getError()[0] }}
                </p>
            @endif
        </div>
        <div class="card-body">
            <form action="{{ route('admin.login') }}" method="POST">
                @csrf
                <div class="input-group mb-3">
                    <input type="email" class="form-control" placeholder="Email" name="email" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" placeholder="Password" name="password" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="{{ Module::asset('admin:plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ Module::asset('admin:plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ Module::asset('admin:js/adminlte.min.js') }}"></script>
</body>
</html>
