<head>
	<meta charset="UTF-8">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
	
	<meta name="csrf-token" content="{{ csrf_token() }}">
	
	<title>@yield('title', 'E-learning | Home')</title>

	<!-- General CSS Files -->
	<link rel="stylesheet" href="{{asset('assets/common/modules/bootstrap/css/bootstrap.min.css')}}">

	<script src="https://kit.fontawesome.com/469f55554f.js" crossorigin="anonymous"></script>

	<!-- CSS Libraries -->
	<link rel="stylesheet" href="{{asset('assets/common/modules/jqvmap/dist/jqvmap.min.css')}}">
	<link rel="stylesheet" href="{{asset('assets/common/modules/summernote/summernote-bs4.css')}}">
	

	<link rel="stylesheet" href="{{asset('assets/common//modules/izitoast/css/iziToast.min.css')}}">

	<!-- Template CSS -->
	<link rel="stylesheet" href="{{asset('assets/common/css/style.css')}}">
	<link rel="stylesheet" href="{{asset('assets/common/css/components.css')}}">

	<!-- DRAG AND DROP -->

	<link rel="stylesheet" href="{{asset('assets/common/css/draganddrop.css')}}">


	@yield('extra-head')

	<link rel="stylesheet" href="{{asset('assets/aula/css/custom.css')}}">
	<link rel="stylesheet" href="{{asset('assets/common/css/fonts.css')}}">
	

	<!-- VIDEO.JS ---->
	<link href="https://vjs.zencdn.net/8.3.0/video-js.css" rel="stylesheet" />


</head>