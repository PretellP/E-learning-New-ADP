@extends('home.layout.masterpage')

@section('content')

<!-- Carousel Start -->

<div class="container-fluid p-0 mb-5 principal-carrousel-container">

    <div class="owl-carousel header-carousel position-relative">

        <div class="owl-carousel-item position-relative">

            <img class="img-fluid" src="{{asset('assets/home/img/carousel-1.jpeg')}}" alt="">

            <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center"
                style="background: rgba(24, 29, 56, .7);">
                <div class="container">
                    <div class="row justify-content-start">
                        <div class="col-sm-10 col-lg-8">
                            <h5 class="text-secondary text-uppercase mb-3 animated slideInDown">Best Online Courses
                            </h5>
                            <h1 class="display-3 text-white animated slideInDown">The Best Online Learning Platform
                            </h1>
                            <p class="fs-5 text-white mb-4 pb-2">Vero elitr justo clita lorem. Ipsum dolor at sed
                                stet sit diam no. Kasd rebum ipsum et diam justo clita et kasd rebum sea sanctus
                                eirmod elitr.</p>
                            {{-- <a href="" class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft">Read
                                More</a>
                            <a href="" class="btn btn-light py-md-3 px-md-5 animated slideInRight">Join Now</a> --}}
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="owl-carousel-item position-relative">

            <img class="img-fluid" src="{{asset('assets/home/img/carousel-2.jpg')}}" alt="">

            <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center"
                style="background: rgba(24, 29, 56, .7);">
                <div class="container">
                    <div class="row justify-content-start">
                        <div class="col-sm-10 col-lg-8">
                            <h5 class="text-secondary text-uppercase mb-3 animated slideInDown">Best Online Courses
                            </h5>
                            <h1 class="display-3 text-white animated slideInDown">Get Educated Online From Your Home
                            </h1>
                            <p class="fs-5 text-white mb-4 pb-2">Vero elitr justo clita lorem. Ipsum dolor at sed
                                stet sit diam no. Kasd rebum ipsum et diam justo clita et kasd rebum sea sanctus
                                eirmod elitr.</p>
                            {{-- <a href="" class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft">Read
                                More</a>
                            <a href="" class="btn btn-light py-md-3 px-md-5 animated slideInRight">Join Now</a> --}}
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>

<!-- Carousel End -->


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
                    <img class="img-fluid position-absolute w-100 h-100" src="{{asset('assets/home/img/about.jpg')}}"
                        alt="" style="object-fit: cover;">
                </div>
            </div>
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                <h6 class="section-title bg-white text-start text-primary pe-3">Acerca de nosotros</h6>
                <h1 class="mb-4">Bienvenido a ADP eLearning</h1>
                <p class="mb-4">Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit. Aliqu diam amet diam et
                    eos. Clita erat ipsum et lorem et sit.</p>
                <p class="mb-4">Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit. Aliqu diam amet diam et
                    eos. Clita erat ipsum et lorem et sit, sed stet lorem sit clita duo justo magna dolore erat amet
                </p>
                <div class="row gy-2 gx-4 mb-4">
                    <div class="col-sm-6">
                        <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Instructores calificados</p>
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


<!-- Courses Start -->

@include('home.courses.partials._courses_list')

<!-- Courses End -->


<!-- Categories Start -->

@include('home.freecourses.partials.boxes._categories_list')

<!-- Categories Start -->





<!-- Team Start -->
{{-- <div class="container-xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title bg-white text-center text-primary px-3">Instructores</h6>
            <h1 class="mb-5">Instructores expertos</h1>
        </div>
        <div class="row g-4">



        </div>
    </div>
</div> --}}
<!-- Team End -->


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
                        <img class="img-fluid img-cover" src="{{ verifyUserAvatar($instructor->file) }}" alt="">
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

@endsection