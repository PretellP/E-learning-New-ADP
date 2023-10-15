@extends('auth.layouts.login-layout')

@section('title', 'Aula Virtual | Login')

@section('content')

<main class="main-content main-login mt-0">

	<span class="bg-filter"></span>

	<div class="page-header min-vh-100">

		<div class="right-container register container">
			
			<div class="right-form-container register">

				<div class="cont-txt-login d-flex">
					<img src="{{ asset('assets/common/images/logo.png') }}" alt="">
					<div class="txt-login-title">
						MODELO
					</div>
					<div class="txt-login-subtitle">
						PLATAFORMA
					</div>
				</div>

				<div class="aula-title text-center">
					SOLICITUD DE REGISTRO
				</div>

				<div class="card-body" id="register-content-box">
					
					@include('auth.partials.boxes._register_form')

				</div>
			</div>
		</div>
	</div>

</main>

@endsection