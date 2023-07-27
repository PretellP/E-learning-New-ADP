<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">

        <div class="sidebar-brand">
            <a href="{{route('aula.index')}}">
                <img src="{{asset('assets/common/images/logo-white.png')}}" alt="">
            </a>
        </div>
        
        <div class="sidebar-brand hidden sidebar-brand-sm">
            <a href="{{route('aula.index')}}">
                <img src="{{asset('assets/common/images/logo-white.png')}}" alt="">
            </a>
        </div>

        <ul class="sidebar-menu">

            <li class="{{setActive('aula.index')}}">
                <a href="{{route('aula.index')}}" class="nav-link">
                    <i class="fa-solid fa-house"></i>
                    <span>Inicio</span>
                </a>
            </li>

            <li class="dropdown profile-dropdown {{setActive('aula.profile.*')}}" >
                <a href="#" class="nav-link has-dropdown">
                    <div class="img-avatar-box">
                        <img src="{{asset(Auth::user()->url_img)}}" alt="">
                    </div>
                    <span>
                        <div class="name">
                            {{strtolower(Auth::user()->name)}}
                        </div>
                        <div class="email">
                            {{strtolower(Auth::user()->email)}}
                        </div>
                    </span>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="{{route('aula.profile.index')}}" class="nav-link">
                            <i class="fa-solid fa-circle fa-2xs"></i>
                            Ver Perfil
                        </a>
                    </li>
                </ul>
            </li>

            <li class="{{setActive('aula.course.*')}}">
                <a href="{{route('aula.course.index')}}" class="nav-link">
                    <i class="fa-solid fa-book"></i>
                    <span>E-Learning</span>
                </a>
            </li>

            <li class="{{setActive('aula.myprogress.*')}}">
                <a class="nav-link" href="{{route('aula.myprogress.index')}}">
                    <i class="fa-solid fa-chart-pie"></i>
                    <span>Mi Progreso</span>
                </a>
            </li>

            <li class="{{setActive('aula.freecourse.*')}}">
                <a href="{{route('aula.freecourse.index')}}" class="nav-link">
                    <i class="fa-solid fa-laptop-file"></i>
                    <span>Cursos Libres</span>
                </a>
            </li>

            <li>
                <a href="#" class="nav-link">
                    <i class="fa-solid fa-square-poll-vertical"></i>
                    <span>Encuestas</span>
                </a>
            </li>

            <li>
                <a href="#" class="nav-link" onclick="event.preventDefault(); 
                document.getElementById('logout-form').submit();">
                   <i class="fa-solid fa-right-from-bracket"></i>
                    <span>Cerrar sesión</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>

        </ul>

    </aside>
</div>