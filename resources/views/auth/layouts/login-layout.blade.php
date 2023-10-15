<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> @yield('title', 'HAMA') </title>

    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Bai+Jamjuree:wght@200;300;500;600&display=swap">

    <script src="{{ asset('js/app.js') }}" defer></script>

    <script src="https://kit.fontawesome.com/469f55554f.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="{{asset('assets/common/css/fonts.css')}}">

    <link rel="stylesheet" href="{{asset('assets/login/css/login-styles.css')}}">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body class="bg-gray-200">
    
    @yield('content')


<script src="{{asset('assets/common/modules/jquery.min.js')}}"></script>
<script src="{{asset('assets/common/js/jquery.validator.js')}}"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="{{ asset('assets/auth/auth.js') }}"></script>

</body>
</html>