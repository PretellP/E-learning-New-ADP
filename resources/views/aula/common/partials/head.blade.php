<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> @yield('title', 'HAMA') </title>

    <script src="https://kit.fontawesome.com/469f55554f.js" crossorigin="anonymous"></script>

    <link id="pagestyle" href="{{ asset('assets/aula/css/material-dashboard.css?v=3.0.0') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{asset('assets/aula/css/styles.css')}}">

</head>