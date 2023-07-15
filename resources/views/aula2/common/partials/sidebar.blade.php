<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">

        <div class="sidebar-brand">
            <a href="{{route('aula.index')}}">
                <img src="{{asset('assets/common/images/logo.png')}}" alt="">
            </a>
        </div>
        <div class="sidebar-brand hidden sidebar-brand-sm">
            <a href="{{route('aula.index')}}">
                <img src="{{asset('assets/common/images/logo.png')}}" alt="">
            </a>
        </div>

        <ul class="sidebar-menu">

            <li class="dropdown profile-dropdown {{setActive('aula.index')}}">
                <a href="#" class="nav-link has-dropdown">
                    <i class="fa-solid fa-circle-user"></i>
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
                        <a class="nav-link" href="">
                            <i class="fa-solid fa-circle fa-2xs"></i>
                            Ver Perfil
                        </a>
                    </li>
                </ul>
            </li>

            <li class="">
                <a href="{{route('aula.course.index')}}" class="nav-link">
                    <i class="fa-solid fa-book"></i>
                    <span>E-Learning</span>
                </a>
            </li>

            <li>
                <a class="nav-link" href="blank.html">
                    <i class="fa-solid fa-chart-pie"></i>
                    <span>Mi Progreso</span>
                </a>
            </li>

            <li>
                <a href="#" class="nav-link">
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

        </ul>

    </aside>
</div>