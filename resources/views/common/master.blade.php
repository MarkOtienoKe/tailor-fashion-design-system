<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <!-- Title and other stuffs -->
    <title>@lang('common.titles.app-title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">

    <!-- X-CSRF-TOKEN -->
    <meta name="csrf-token" content="{{ csrf_token() }}">



    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="{{URL::asset('bootstrap/css/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{URL::asset('fonts/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{URL::asset('fonts/ionicons.min.css')}}">
    {{--<link rel="stylesheet" href="{{URL::asset('Ic/ionicons.min.css')}}">--}}
    <!-- Theme style -->
    <link rel="stylesheet" href="{{URL::asset('dist/css/AdminLTE.min.css')}}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{URL::asset('dist/css/skins/_all-skins.min.css')}}">
    <link rel="stylesheet" href="{{URL::asset('css/sweetalert2.min.css')}}">
    {{--<link rel="stylesheet" href="{{URL::asset('css/globe.css')}}">--}}

    {{--<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>--}}
    {{--<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>--}}


    <!-- Main stylesheet -->
{{--<link href="{{ URL::asset('css/style.css') }}" rel="stylesheet">--}}

<!--[if lt IE 9]>


    <!-- Favicon -->
    {{--<link rel="shortcut icon" href="{{ URL::asset('img/favicon/favicon.ico') }}">--}}

    @stack('styles')

</head>

<body class="fixed hold-transition skin-purple sidebar-mini">

{{--@unless ( ! Auth::check() )--}}

@include('common.navbar')

<div id="content">@include('common.sidebar') @yield('content')</div>

{{--@endunless--}}

@include('common.footer')

</body>
</html>
