<aside
	class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark"
	id="sidenav-main">

	<div class="sidenav-header">
		<i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
			aria-hidden="true" id="iconSidenav"></i>

		<div class="accordion accordion-user-aside" id="accordionUserAside">
			<div class="accordion-item aside-accordion-item">
				<span class="accordion-header" id="headingOne">
					<button class="accordion-button user-accordion-button collapsed" type="button" data-bs-toggle="collapse"
						data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
						<div class="user-accordion-head">
							<i class="fa-solid fa-user fa-lg"></i>
							<div class="user-info-accordion">
								<span class="user-accordion-name">
									{{Auth::user()->name}}
								</span>
								<span class="user-accordion-email">
									{{Auth::user()->email}}
								</span>
							</div>
						</div>
						<div class="chevron-arrow-rotate">
							<i class="fa-solid fa-chevron-up"></i>
						</div>
					</button>
				</span>
				<div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne"
					data-bs-parent="#accordionUserAside">
					<div class="button-profile-container">

						<div class="show-profile">
							<div class="user-profile-view" id='user-profile-view'>
								<div class="profile-head">
									Información General
								</div>

								<div class="profile-body">
									<div class="content-profile-body">
										<div class="user-icon">
											<i class="fa-solid fa-circle-user fa-lg"></i>
										</div>
										<div class="names-profile-view">
											<span>
												{{strtolower(Auth::user()->name)}}
											</span>
											<span>
												{{strtolower(Auth::user()->paternal)}}
												{{strtolower(Auth::user()->maternal)}}
											</span>
										</div>

										<div class="info-profile-view">
											<div class="info-profile-box">
												<span class="info-profile-label">
													<i class="fa-solid fa-id-card"></i>
													DNI
												</span>
												<span class="info-profile-content">
													{{Auth::user()->dni}}
												</span>
											</div>
											<div class="info-profile-box">
												<span class="info-profile-label">
													<i class="fa-solid fa-building"></i>
													 ECM 
												</span>
												<span class="info-profile-content">
													 {{(getCompanyFromUser())->description}} 
												</span>
											</div>
											<div class="info-profile-box">
												<span class="info-profile-label">
													<i class="fa-solid fa-industry"></i>
													 UNIDAD 
												</span>
												<span class="info-profile-content">
													@foreach (getMiningUnitsFromUser() as $miningUnit)
													<div>
														{{$miningUnit->description}}
													</div>
													@endforeach
												</span>
												
											</div>
											<div class="info-profile-box">
												<span class="info-profile-label">
													<i class="fa-solid fa-user-tie"></i>
													CARGO
												</span>
												<span class="info-profile-content">
													{{Auth::user()->position}}
												</span>
											</div>
											<div class="info-profile-box">
												<span class="info-profile-label">
													<i class="fa-solid fa-envelope"></i>
													CORREO
												</span>
												<span class="info-profile-content">
													{{strtolower(Auth::user()->email)}}
												</span>
											</div>
											<div class="info-profile-box">
												<span class="info-profile-label">
													<i class="fa-solid fa-phone"></i>
													TELÉFONO / CELULAR 
												</span>
												<span class="info-profile-content">
													{{Auth::user()->telephone}}
												</span>
											</div>
											<div class="info-profile-box">
												<span class="info-profile-label">
													<i class="fa-solid fa-id-badge"></i>
													PERFIL
												</span>
												<span class="info-profile-content">
													{{Auth::user()->profile_user}}
												</span>
											</div>
										</div>

									</div>

								</div>
							</div>
						</div>

						<div class="accordion-body accordion-body-user-aside">
							<span>
								Mi perfil
							</span>
							<i class="fa-solid fa-arrow-right"></i>
						</div>


					</div>

				</div>
			</div>
		</div>


	</div>

	<hr class="horizontal light mt-0 mb-2">
	<div class="collapse navbar-collapse mt-4 w-auto max-height-vh-100" id="sidenav-collapse-main">
		<ul class="navbar-nav">
			<li class="nav-item">
				<a class="{{setActive('aula.index')}} nav-link text-white" href="{{route('aula.index')}}">
					<div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
						<i class="fa-solid fa-house"></i>
					</div>
					<span class="nav-link-text ms-1">Inicio</span>
				</a>
			</li>

			<li class="nav-item">
				<a class="{{ setActive('aula.course.*')}} nav-link text-white " href="{{route('aula.course.index')}}">
					<div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
						<i class="fa-solid fa-book"></i>
					</div>
					<span class="nav-link-text ms-1">E-Learning</span>
				</a>
			</li>


			<li class="nav-item">
				<a class="nav-link text-white " href="">
					<div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
						<i class="fa-solid fa-chart-pie"></i>
					</div>
					<span class="nav-link-text ms-1">Mi Progreso</span>
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link text-white " href="">
					<div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
						<i class="fa-solid fa-laptop-file"></i>
					</div>
					<span class="nav-link-text ms-1">Cursos Libres</span>
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link text-white " href="">
					<div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
						<i class="fa-solid fa-square-poll-vertical"></i>
					</div>
					<span class="nav-link-text ms-1">Encuestas</span>
				</a>
			</li>
		</ul>
	</div>
</aside>