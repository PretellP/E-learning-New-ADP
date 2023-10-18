<nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">

    <a href="{{ route('home.index') }}" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
        <h2 class="m-0 text-primary"><i class="fa fa-book me-3"></i>ADP eLEARNING</h2>
    </a>

    <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarCollapse">

        <div class="navbar-nav ms-auto p-4 p-lg-0">

            @auth
            <span class="me-4 my-auto d-flex align-items-center">

                <span class="user-avatar-container me-3">
                    <img src="{{ verifyUserAvatar(Auth::user()->avatar()) }}" alt="">
                </span>

                <b>¡Hola, {{ Auth::user()->full_name }}!</b>
            </span>
    
            @endauth

            <a href="{{ route('home.index') }}" class="nav-item nav-link {{ setActive('home.index') }}">Inicio</a>
            <a href="#" class="nav-item nav-link">Nosotros</a>
            <a href="{{ route('home.courses.index') }}" class="nav-item nav-link  {{ setActive('home.courses.*') }}">Cursos</a>

            @guest

            <a href="{{ route('register.show') }}" class="nav-item nav-link">
                Registrarse
                <i class="fa-solid fa-user-plus ms-2"></i>
            </a>

            @endguest

        </div>


        @guest

        <a href=" {{ route('login') }} " class="btn btn-primary py-4 px-lg-5 d-block">
            Iniciar sesíón
            <i class="fa-solid fa-arrow-right-to-bracket ms-3"></i>
        </a>

        @endguest

        @auth

       
        <a href=" {{ route('login') }} " class="btn btn-primary py-4 px-lg-5 d-block">
            Ingresar al E-Learning
            <i class="fa-solid fa-chalkboard-user ms-3"></i>
            {{-- <i class="fa fa-arrow-right ms-3"></i> --}}
        </a>


        <a href="#" class="nav-link" onclick="event.preventDefault(); 
        document.getElementById('logout-form').submit();">
            <i class="fa-solid fa-power-off"></i> &nbsp;
            <span>Cerrar sesión</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>

        @endauth

    </div>

</nav>