<div class="container-fluid bg-dark text-light footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">


    <div class="container py-5">
        <div class="row g-5">


            <div class="col-lg-4 col-md-6 d-flex flex-column justify-content-between">
                <div class="logo-adp-white">
                    <img src="{{ asset('assets/home/img/adp-logo-white.svg') }}" alt="">
                </div>
                <p class="description-c-o">«El conocimiento es poder y está al alcance de tus manos»</p>
                <div class="d-flex pt-2">
                    <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-twitter"></i></a>
                    <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-youtube"></i></a>
                    <a class="btn btn-outline-light btn-social" href=""><i
                            class="fab fa-linkedin-in"></i></a>
                </div>

            </div>

            <div class="col-lg-4 col-md-6">
                <h4 class="text-white mb-3">Soporte</h4>
                <p class="mb-2"> ¿Tienes alguna duda, consulta o incidencia con el uso de ADP E-Learning? Escríbenos a: </p>

                <h5><a href="">help@adp-elearning.com</a></h5>

            </div>

            <div class="col-lg-4 col-md-12">
                <h4 class="text-white mb-3">Visita nuestras otras páginas</h4>
                <a class="btn btn-link" href="#">Nosotros</a>
                <a class="btn btn-link" href="{{ route('home.courses.index') }}">Cursos</a>
                <a class="btn btn-link" href="">Cursos libres</a>
                <a class="btn btn-link" href="">Registrate!</a>


                {{-- <h4 class="text-white mb-3">Galeria</h4>
                <div class="row g-2 pt-2">
                    <div class="col-4">
                        <img class="img-fluid bg-light p-1" src="{{asset('assets/home/img/course-1.jpg')}}" alt="">
                    </div>
                    <div class="col-4">
                        <img class="img-fluid bg-light p-1" src="{{asset('assets/home/img/course-2.jpg')}}" alt="">
                    </div>
                    <div class="col-4">
                        <img class="img-fluid bg-light p-1" src="{{asset('assets/home/img/course-3.jpg')}}" alt="">
                    </div>
                    <div class="col-4">
                        <img class="img-fluid bg-light p-1" src="{{asset('assets/home/img/course-2.jpg')}}" alt="">
                    </div>
                    <div class="col-4">
                        <img class="img-fluid bg-light p-1" src="{{asset('assets/home/img/course-3.jpg')}}" alt="">
                    </div>
                    <div class="col-4">
                        <img class="img-fluid bg-light p-1" src="{{asset('assets/home/img/course-1.jpg')}}" alt="">
                    </div>
                </div> --}}



            </div>
        </div>
    </div>


    <div class="container">
        <div class="copyright">
            <div class="row">
                <div class="col-md-12 text-center text-md-start mb-3 mb-md-0">

                    <p class="text-center">
                        Copyright &copy; {{ date('Y') }} <a class="border-bottom" href="#">E-Learning ADP</a>.
                        Reservados todos los derechos.
                    </p>

                </div>
            </div>
        </div>
    </div>


</div>
