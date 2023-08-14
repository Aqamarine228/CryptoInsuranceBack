<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Insurance Admin</title>
    <link rel="icon" type="image/x-icon" href="{{ Module::asset('admin:img/favicon.ico') }}">

    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ Module::asset('admin:plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ Module::asset('admin:plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet"
          href="{{ Module::asset('admin:plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ Module::asset('admin:css/adminlte.min.css') }}">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

    @include('admin::layouts._navbar')
    @include('admin::layouts._sidebar')

    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                @include('admin::layouts._alerts')
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>@yield('title')</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            @yield('breadcrumb')
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            @yield('content')
        </section>
    </div>

    @include('admin::layouts._footer')

</div>

@include('admin::layouts._scripts')
</body>
</html>
