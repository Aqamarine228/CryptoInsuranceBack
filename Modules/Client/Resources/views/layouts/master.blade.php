<!DOCTYPE html>
<html lang="en" class="yes-js js_active js">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{Str::title(config('client.company_name'))}}</title>
    <link rel="icon" type="image/x-icon" href="{{Module::asset('client:images/favicons/favicon.ico')}}">
    <link
        href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    @include('client::layouts._styles')
    <style>

        .locale {
            display: flex;
            justify-content: center;
        }

        .locale a {
            margin-left: 30px;
            margin-right: 30px;
        }
        @media (min-width: 1199px) {
            .locale {
                display: none;
            }

            .only-mobile {
                display: none;
            }
        }
    </style>
</head>
<body class="custom-cursor">
<div class="custom-cursor__cursor"></div>
<div class="custom-cursor__cursor-two"></div>

<div class="preloader">
    <div class="preloader__image"></div>
</div>

<div class="page-wrapper">
    @include('client::layouts._header')
    <div data-elementor-type="wp-page" data-elementor-id="34" class="elementor elementor-34">
        @yield('content')
    </div>
    @include('client::layouts._footer')
    @include('client::layouts._mobile_navigation')
</div>
@include('client::layouts._search-popup')
<a href="#" data-target="html" class="scroll-to-target scroll-to-top" style="margin-bottom: 30px"><i class="fa fa-angle-up"></i></a>
@include('client::layouts._scripts')
</body>
</html>
