<nav class="navbar navbar-main navbar-expand-lg mt-3 mx-4 shadow-none border-radius-xl" id="navbarBlur"
    navbar-scroll="true">
    <div class="container-fluid py-1 px-3">

        <div class="box-logo">
            <img src="{{asset('assets/common/images/logo.png')}}" alt="">
            <span>Nombre de la Empresa</span>
        </div>

        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <ul class="ms-md-auto navbar-nav  justify-content-end">
                <li class="nav-item d-flex align-items-center">
                    <a href="" class="logout-link nav-link text-body font-weight-bold px-0"
                        onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                        <i class="fa-solid fa-right-from-bracket fa-flip-horizontal"></i> &nbsp;
                        <span class="d-sm-inline d-none">Salir</span>
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>

                </li>

                <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
        
    </div>
</nav>