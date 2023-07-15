<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
        </ul>

    </form>
    <ul class="navbar-nav navbar-right">

        <li class="dropdown">

            <a href="#" onclick="event.preventDefault(); 
            document.getElementById('logout-form').submit();" class="nav-link nav-link-lg nav-link-user">
                <i class="fa-solid fa-arrow-right-from-bracket fa-flip-horizontal"></i> &nbsp;
                <div class="d-sm-none d-lg-inline-block">Cerrar Sesión</div>
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </li>
    </ul>
</nav>