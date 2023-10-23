<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">

        <div class="sidebar-brand">
            <a href="">
                <img src="" alt="">
            </a>
        </div>
        
        <div class="sidebar-brand hidden sidebar-brand-sm">
            <a href="">
                <img src="" alt="">
            </a>
        </div>

        <ul class="sidebar-menu">

            <li class="{{setActive('admin.home.*')}}">
                <a href="{{route('admin.home.index')}}" class="nav-link">
                    <i class="fa-solid fa-house"></i>
                    <span>Inicio</span>
                </a>
            </li>

            <li class="{{setActive('admin.users.*')}}">
                <a href="{{route('admin.users.index')}}" class="nav-link">
                    <i class="fa-solid fa-users"></i>
                    <span>Usuarios</span>
                </a>
            </li>

            <li class="{{setActive('admin.companies.*')}}">
                <a href="{{route('admin.companies.index')}}" class="nav-link">
                    <i class="fa-solid fa-building"></i>
                    <span>Empresas</span>
                </a>
            </li>

            <li class="{{setActive('admin.ownerCompanies.*')}}">
                <a href="{{route('admin.ownerCompanies.index')}}" class="nav-link">
                    <i class="fa-regular fa-building"></i>
                    <span>Empresas Titulares</span>
                </a>
            </li>

            <li class="{{setActive('admin.miningUnits.*')}}">
                <a href="{{route('admin.miningUnits.index')}}" class="nav-link">
                    <i class="fa-solid fa-mountain-city"></i>
                    <span>Unidades Mineras</span>
                </a>
            </li>

            <li class="{{setActive('admin.rooms.*')}}">
                <a href="{{route('admin.rooms.index')}}" class="nav-link">
                    <i class="fa-solid fa-chalkboard-user"></i>
                    <span>Salas</span>
                </a>
            </li>

            <li class="{{setActive('admin.courses.*')}}">
                <a class="nav-link" href="{{route('admin.courses.index')}}">
                    <i class="fa-solid fa-book"></i>
                    <span>Cursos</span>
                </a>
            </li>

            <li class="{{setActive('admin.freeCourses.*')}}">
                <a href="{{route('admin.freeCourses.index')}}" class="nav-link">
                    <i class="fa-solid fa-book-open"></i>
                    <span>Cursos Libres</span>
                </a>
            </li>

            <li class="{{setActive('admin.exams.*')}}">
                <a href="{{route('admin.exams.index')}}" class="nav-link">
                    <i class="fa-solid fa-file-signature"></i>
                    <span>Exámenes</span>
                </a>
            </li>

            <li class="{{setActive('admin.events.*')}}">
                <a href="{{route('admin.events.index')}}" class="nav-link">
                    <i class="fa-solid fa-calendar-days"></i>
                    <span>Eventos</span>
                </a>
            </li>

            <li class="{{setActive('admin.announcements.*')}}">
                <a href="{{route('admin.announcements.index')}}" class="nav-link">
                    <i class="fa-solid fa-bullhorn"></i>
                    <span>Anuncios</span>
                </a>
            </li>

            <li class="{{setActive('admin.surveys.*')}}">
                <a href="{{ route('admin.surveys.index') }}" class="nav-link">
                    <i class="fa-solid fa-square-poll-vertical"></i>
                    <span>Encuestas</span>
                </a>
            </li>

            


            

            <li class="logout">
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