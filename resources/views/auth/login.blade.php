@extends('auth.layouts.login-layout')

@section('title', 'Aula Virtual | Login')

@section('content')

<main class="main-content main-login mt-0">

	<span class="bg-filter"></span>

	<div class="page-header min-vh-100">

		<div class="d-flex inner-container-login">
			<div class="left-container">
				<div class="left-img-login">
	
				</div>
			</div>
	
			<div class="right-container container flex-column">
	
				@if (session('error'))
				<div class="alert alert-danger">
						{{ session('error') }}
				</div>
				@endif
				
				<div class="right-form-container">
	
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
						AULA VIRTUAL
					</div>
	
					<div class="card-body">
						<form method="POST" action="{{ route('login') }}" role="form" class="text-start login-form">
	
							@csrf
	
							<div class="input-box my-4">
	
								<input id="dni" name="dni" type="text"
									class="form-control @error('dni') is-invalid @enderror" required
									autocomplete="dni" value="{{old('dni')}}" placeholder="Id usuario">
	
								@error('dni')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
								@enderror
	
							</div>
	
	
							<div class="input-box mb-3">
	
								<input id="password" name="password" type="password" required
									class="form-control @error('dni') is-invalid @enderror"
									placeholder="Contraseña">
							</div>
	
							<div class="text-center btn-login-submit">
								<button type="submit" class="btn w-100 my-4 mb-2">{{_('INGRESAR')}}</button>
							</div>
	
				
	
						</form>
	
					</div>
	
					<div class="links-bottom-container-login d-flex flex-column align-items-center mt-1">
	
						<span>
							¿Aún no tienes una cuenta?
							<a href="{{ route('register.show') }}">
								Regístrate
							</a>
						</span>
	
						<a href="{{ route('home.index') }}">
							<i class="fa-solid fa-angles-left"></i>
							Volver a la página de inicio
						</a>
		
					</div>
	
				</div>
	
				
	
			</div>
		</div>
		
	</div>


</main>

@endsection