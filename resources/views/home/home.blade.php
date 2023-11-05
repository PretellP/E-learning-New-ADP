@extends('home.layout.masterpage')

@section('content')
    <!-- Carousel Start -->

    <div class="container-fluid p-0 mb-5 principal-carrousel-container">

        <div class="owl-carousel header-carousel position-relative">

            <div class="owl-carousel-item position-relative">

                <img class="img-fluid" src="{{ asset('assets/home/img/carousel-1.jpeg') }}" alt="">

                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center"
                    style="background: rgba(24, 29, 56, .7);">
                    <div class="container">
                        <div class="row justify-content-start">
                            <div class="col-sm-10 col-lg-9">
                                <h5 class="text-secondary text-uppercase mb-3 animated slideInDown">El Futuro del
                                    Aprendizaje
                                </h5>
                                <h2 class="display-3 text-white animated slideInDown">Bienvenido a ADP E-Learning.</h2>
                                <h2 class="display-3 text-white animated slideInDown">Tu destino para el aprendizaje en
                                    línea.</h2>
                                <p class="fs-5 text-white mb-4 pb-2">Aquí, el conocimiento es poder y está al alcance de tus
                                    manos. Nuestra plataforma te ofrece una experiencia educativa única, donde la
                                    flexibilidad se combina con la calidad.</p>
                                {{-- <a href="" class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft">Read
                                More</a>
                            <a href="" class="btn btn-light py-md-3 px-md-5 animated slideInRight">Join Now</a> --}}
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="owl-carousel-item position-relative">

                <img class="img-fluid" src="{{ asset('assets/home/img/carousel-2.jpg') }}" alt="">

                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center"
                    style="background: rgba(24, 29, 56, .7);">
                    <div class="container">
                        <div class="row justify-content-start">
                            <div class="col-sm-10 col-lg-8">
                                <h5 class="text-secondary text-uppercase mb-3 animated slideInDown">Transforma tu futuro hoy</h5>
                                <h2 class="display-3 text-white animated slideInDown">¡Descubre el Poder del Aprendizaje en Línea con ADP Learning!</h2>
                                <p class="fs-5 text-white mb-4 pb-2">Ofrecemos una variedad de cursos en línea diseñados para ayudarte a alcanzar tus metas profesionales y personales. Nuestros programas de estudio son flexibles, interactivos y están llenos de información relevante y actualizada.</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Carousel End -->

{{--
    <div class="count-up-wrapper top">
        <span id="count-up-container-top">0</span>
        <span class="additional-info">Stars in Github:</span>
    </div>
    <div class="count-up-wrapper bottom">
        <span class="additional-info">Used by:</span>
        <span id="count-up-container-bottom">0</span>
    </div> --}}


    {{-- <div class="end-container">Thanks for watching</div> --}}

    {{-- * walllace add --}}

    <div class="container-xxl py-5 courses-container">
        <div class="container wow fadeInUp" data-wow-delay="0.1s">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">Construyendo</h6>
                <h1 class="mb-5">Construyendo equipos listos para el futuro</h1>
            </div>
            <div class="row justify-content-center">
                {{-- <h3 class="col-12 text-center p-4">Construyendo equipos listos para el futuro</h3> --}}
                <div class="col-sm-12 col-lg-3 text-center">
                    <span id="count-up-students" class="making-numbers" data-number="{{ $numberUsers }}"></span>
                    <p>estudiantes registrados en nuestra plataforma.</p>
                </div>
                <div class="col-sm-12 col-lg-3 text-center">
                    <span id="count-up-courses" class="making-numbers" data-number="{{ $numberCourses }}"></span>
                    <p>cursos publicados.</p>
                </div>
                <div class="col-sm-12 col-lg-3 text-center">
                    <span id="count-up-companys" class="making-numbers" data-number="{{ $numberCompanys }}"></span>
                    <p>empresas desarrollando a sus equipos con nosotros.</p>
                </div>
            </div>
        </div>
    </div>



    <div class="container-xxl py-5 courses-container">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">Características</h6>
                <h1>Características que nos hacen únicos</h1>
                <p class="mb-5 col-12 text-center p-4">El único sistema para capacitar a tu personal de campo y atención al
                    cliente y validar su aprendizaje</p>
            </div>
            <div class="row">
                <div class="col-sm-12 col-lg-4 wow fadeInUp" data-wow-delay="0.1s"">
                    <div class="div-effect d-flex flex-column">
                        <div class="card-img">
                            <img class="w-100" src="{{ asset('assets/home/img/content-one.svg') }}" alt="">
                        </div>
                        <div class="container-description p-5">
                            <h4 class="title-description">Interacción directa con <br> los contenidos</h4>
                            <p>Los estudiantes pueden interactuar con los materiales del curso de manera activa, lo que puede mejorar la comprensión y el aprendizaje.</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-4 wow fadeInUp" data-wow-delay="0.3s"">
                    <div class="div-effect d-flex flex-column">
                        <div class="card-img">
                            <img class="w-100" src="{{ asset('assets/home/img/phone-one.svg') }}" alt="">
                        </div>
                        <div class="container-description p-5">
                            <h4 class="title-description">Flexible, intuitiva y <br> autogestionable</h4>
                            <p>Personaliza y centraliza tu plan de entrenamiento segmentando el contenido en función a la estructura de tu equipo.</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-4 wow fadeInUp" data-wow-delay="0.5s"">
                    <div class="div-effect d-flex flex-column">
                        <div class="card-img">
                            <img class="w-100" src="{{ asset('assets/home/img/laptop-one.svg') }}" alt="">
                        </div>
                        <div class="container-description p-5">
                            <h4 class="title-description">Nos actualizamos <br> contigo</h4>
                            <p>Actualizamos constantemente nuestro E-Learning System, tomando en cuenta tu feedback y el de tus colaboradores.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    {{-- * walllace end --}}


    <!-- Courses Start -->

    @include('home.courses.partials._courses_list')

    <!-- Courses End -->


    <!-- Categories Start -->

    @include('home.freecourses.partials.boxes._categories_list')

    <!-- Categories Start -->


    {{-- faq start --}}

    <div class="container-xxl py-5 courses-container">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">Preguntas</h6>
                <h1 class="mb-5">Preguntas frecuentes</h1>
            </div>
            <div class="row">
                <div class="col-sm-12 col-lg-6 text-center wow fadeInUp" data-wow-delay="0.1s">
                    <img class="w-75" src="{{ asset('assets/home/img/image-FaQ.jpg') }}" alt="">
                </div>
                <div class="col-sm-12 col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    ¿Cómo puedo acceder a los materiales del curso?
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    Los materiales del curso suelen estar disponibles en la plataforma de e-learning. Puedes encontrarlos en la sección de recursos del curso o en el aula virtual, dependiendo de la plataforma que estés utilizando.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    ¿Qué hago si tengo problemas técnicos?
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    Si tienes problemas técnicos, lo mejor es ponerse en contacto con el soporte técnico de la plataforma. También puedes consultar la sección de preguntas frecuentes o el manual del usuario para obtener ayuda.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    ¿Cómo puedo interactuar con otros estudiantes y con el profesor?
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    La mayoría de las plataformas de e-learning ofrecen foros de discusión donde puedes interactuar con otros estudiantes y con el profesor. También puedes utilizar el correo electrónico o la mensajería instantánea para comunicarte directamente con ellos.
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- faq end --}}

    {{-- <script src="{{asset('assets/home/js/countUp.js')}}"></script> --}}
    <script src="{{ asset('assets/home/js/contador.js') }}" type="module"></script>
@endsection
