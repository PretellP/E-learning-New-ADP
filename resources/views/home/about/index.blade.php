@extends('home.layout.masterpage')

@section('content')
    <!-- Header Start -->
    <div class="container-fluid bg-primary py-5 mb-5 page-header">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <h1 class="display-3 text-white animated slideInDown">Sobre Nosotros</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a class="text-white" href="{{ route('home.index') }}">Inicio</a></li>
                            <li class="breadcrumb-item text-white active" aria-current="page">Nosotros</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Header End -->


    <!-- Service Start -->

    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="service-item text-center pt-3">
                        <div class="p-4">
                            <i class="fa fa-3x fa-graduation-cap text-secondary mb-4"></i>
                            <h5 class="mb-3">Instructores calificados</h5>
                            <p>Nuestros instructores han sido cuidadosamente
                                seleccionados por su conocimiento profundo, habilidades de enseñanza excelentes y
                                experiencia en el mundo real.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="service-item text-center pt-3">
                        <div class="p-4">
                            <i class="fa fa-3x fa-globe text-secondary mb-4"></i>
                            <h5 class="mb-3">Clases online</h5>
                            <p>Nuestras clases en línea te brindan la ventaja de mantener tus habilidades y conocimientos
                                actualizados. Estarás preparado para los desafíos que el futuro te presente.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="service-item text-center pt-3">
                        <div class="p-4">
                            <i class="fa-solid fa-file-lines text-secondary mb-4 fa-3x"></i>
                            <h5 class="mb-3">Certificados</h5>
                            <p>Celebramos tus logros y te brindamos el reconocimiento oficial que mereces por tu arduo
                                trabajo y dedicación en el proceso de aprendizaje. Son la prueba de tu compromiso con la
                                excelencia.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="service-item text-center pt-3">
                        <div class="p-4">
                            <i class="fa-solid fa-person-chalkboard text-secondary mb-4 fa-3x"></i>
                            <h5 class="mb-3">Eventos en vivo</h5>
                            <p>Te brindamos una oportunidad única para conectarte con instructores y expertos en tiempo
                                real, lo que agrega una dimensión interactiva excepcional a tu educación.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Service End -->




    <!-- About Start -->

    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s" style="min-height: 400px;">
                    <div class="position-relative h-100">
                        <img class="img-fluid position-absolute w-100 h-100" src="{{ asset('assets/home/img/about.jpg') }}"
                            alt="" style="object-fit: cover;">
                    </div>
                </div>
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                    <h6 class="section-title bg-white text-start text-primary pe-3">Acerca de nosotros</h6>
                    <h1 class="mb-4">¡Bienvenidos a ADP E-Learning!</h1>
                    <p class="mb-4">Somos una plataforma dedicada a la educación en línea, comprometida con el crecimiento y desarrollo de nuestros estudiantes. Nuestro objetivo es proporcionar un aprendizaje accesible, asequible y de alta calidad para todos, independientemente de dónde se encuentren.</p>
                    <p class="mb-4">En ADP E-Learning, creemos en el poder de la educación para transformar vidas. Nuestros cursos están diseñados para ser interactivos, atractivos y fáciles de entender, permitiendo a los estudiantes aprender a su propio ritmo.
                    </p>
                    <div class="row gy-2 gx-4 mb-4">
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Instructores calificados
                            </p>
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Clases online</p>
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Certificados
                            </p>
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Eventos de vivo</p>
                        </div>
                    </div>
                    {{-- <a class="btn btn-primary py-3 px-5 mt-2" href="">Read More</a> --}}
                </div>
            </div>
        </div>
    </div>

    <!-- About End -->

    <!-- Testimonial Start -->

    <div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container">
            <div class="text-center">
                <h6 class="section-title bg-white text-center text-primary px-3">Instructores</h6>
                <h1 class="mb-5">Instructores expertos</h1>
            </div>

            <div class="owl-carousel testimonial-carousel position-relative">

                @forelse ($instructors as $instructor)
                    <div class="wow fadeInUp" data-wow-delay="0.1s">
                        <div class="team-item bg-light">
                            <div class="overflow-hidden image-user-container">
                                <img class="img-fluid img-cover" src="{{ verifyUserAvatar($instructor->file) }}"
                                    alt="">
                            </div>

                            <div class="text-center p-4">
                                <h5 class="mb-0">
                                    {{ ucwords(mb_strtolower($instructor->full_name, 'UTF-8')) }}
                                </h5>
                                <small>
                                    {{ $instructor->email ?? '-' }}
                                </small>
                            </div>
                        </div>
                    </div>

                @empty

                    <h4 class="text-center empty-records-message"> No hay Instructores que mostrar </h4>
                @endforelse

            </div>

        </div>
    </div>

    <!-- Testimonial End -->







    <!-- Courses Start -->

    {{-- @include('home.freecourses.partials.boxes._categories_list') --}}

    <!-- Courses End -->
@endsection
