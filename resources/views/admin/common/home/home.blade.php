@extends('admin.common.layouts.masterpage')

@section('content')
    <div class="row content">

        <div class="main-container-page">
            <div class="card page-title-container">
                <div class="card-header">
                    <div class="total-width-container">
                        <h4>INICIO</h4>
                    </div>
                </div>
            </div>

            <div class="card-body card z-index-2 principal-container container-dashboard">

                <div class="row sortable-card">

                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="card card-primary card-back">
                            <div class="card-header card-header-w">
                                <h4></h4>
                                <div class="card-header-action">
                                    <a href=" {{ route('admin.users.index') }} ">
                                        <i class="fa-solid fa-arrow-up-right-from-square icon-href"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="card-body card-body-dashboard">
                                <div class="container-icon-d">
                                    <i class="icon-info-d fa-solid fa-user icon-users-blue"></i>
                                </div>
                                <div class="numbers">
                                    <h2 id="count-up-users" data-number="{{ $users }}" class="count-numbers">0</h2>
                                </div>
                                <p class="reference-count">Usuarios</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 col-lg-2">
                        <div class="card card-primary card-back">
                            <div class="card-header card-header-w">
                                <h4></h4>
                                <div class="card-header-action">
                                    <a href="{{ route('admin.companies.index') }}">
                                        <i class="fa-solid fa-arrow-up-right-from-square icon-href"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="card-body card-body-dashboard">
                                <div class="container-icon-d">
                                    <i class="icon-info-d fa-solid fa-building icon-building-red"></i>
                                </div>
                                <div class="numbers">
                                    <h2 id="count-up-companys" data-number="{{ $company }}" class="count-numbers">0
                                    </h2>
                                </div>
                                <p class="reference-count">Empresas</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 col-lg-2">
                        <div class="card card-primary card-back">
                            <div class="card-header card-header-w">
                                <h4></h4>
                                <div class="card-header-action">
                                    <a href="{{ route('admin.courses.index') }}">
                                        <i class="fa-solid fa-arrow-up-right-from-square icon-href"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="card-body card-body-dashboard">
                                <div class="container-icon-d">
                                    <i class="icon-info-d fa-solid fa-book icon-book-green"></i>
                                </div>
                                <div class="numbers">
                                    <h2 id="count-up-course-regular" data-number="{{ $courseRegular }}"
                                        class="count-numbers">0</h2>
                                </div>
                                <p class="reference-count">Cursos</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 col-lg-2">
                        <div class="card card-primary card-back">
                            <div class="card-header card-header-w">
                                <h4></h4>
                                <div class="card-header-action">
                                    <a href="{{ route('admin.freeCourses.index') }}">
                                        <i class="fa-solid fa-arrow-up-right-from-square icon-href"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="card-body card-body-dashboard">
                                <div class="container-icon-d">
                                    <i class="icon-info-d fa-solid fa-book icon-book-purple"></i>
                                </div>
                                <div class="numbers">
                                    <h2 id="count-up-course-free" data-number="{{ $courseFree }}" class="count-numbers">0
                                    </h2>
                                </div>
                                <p class="reference-count">Cursos libres</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="card card-primary card-back">
                            <div class="card-header card-header-w">
                                <h4></h4>
                                <div class="card-header-action">
                                    <a href="{{ route('admin.events.index') }}">
                                        <i class="fa-solid fa-arrow-up-right-from-square icon-href"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="card-body card-body-dashboard">
                                <div class="container-icon-d">
                                    <i class="icon-info-d fa-solid fa-calendar-days icon-events-yellow"></i>
                                </div>
                                <div class="numbers">
                                    <h2 id="count-up-events" data-number="{{ $events }}" class="count-numbers">0</h2>
                                </div>
                                <p class="reference-count">Eventos</p>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row">
                    {{-- * ChartJs --}}
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card card-primary card-back">
                            <div class="card-header card-header-chart">
                                <h4 class="title-chart">Estado de los alumnos de {{ $nameMonth }}</h4>
                            </div>
                            <div class="card-body" id="card-body-first-chart">
                                <h6 id="student-status" class="student-status">Oops... Los alumnos aún no han dado alguna evaluación este mes.</h6>
                                <canvas data-approved="{{ $approved }}" data-suspended="{{ $suspended }}"
                                    id="chart-student-status">
                                </canvas>
                            </div>
                        </div>
                    </div>


                    <div class="col-12 col-md-12 col-lg-8">
                        <div class="card card-primary card-back">
                            <div class="card-header card-header-chart">
                                <h4 class="title-chart">Tipos de Usuarios</h4>
                            </div>
                            <div class="card-body">
                                <canvas data-types="{{ $typesOfUsers }}" id="chart-types-of-users">
                                </canvas>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

        </div>
    @endsection

    @section('extra-script')
        <script src="{{ asset('assets/admin/js/chartDashboard.js') }}"></script>
        <script src="{{ asset('assets/common/js/contador.js') }}" type="module"></script>
    @endsection
