@extends('aula.common.layouts.dashboard')

@section('sub_content')

<div class="row general-container-page-info">
    <div class="body-container-page-info">

        <div class="col-12 mb-0">
            <div class="card pt-5 box-container-info">
                <div class="welcome-page-info">
                    <span>AULA VIRTUAL</span>
                </div>
                <div class="names-page-info">
                    <span>
                        E-LEARNING
                    </span>
                </div>
                <hr class="divider-page-info">
                <div class="extra-page-info">
                    <span>
                        Bienvenido al Aula Virtual, {{Auth::user()->name}}
                    </span>
                </div>
            </div>
        </div>

    </div>

</div>

<div class="row">

    <div class="body-page-container col-12">

        <div class="card z-index-2 g-course-flex">

            <div class="row mt-5 w-100">

                <div class="course-container">

                    @forelse($courses as $course)
                    @php
                    $instructors = getInstructorsBasedOnUserAndCourse($course);
                    @endphp

                    <div class="card course-card">
                        <div class="course-img-container">
                            <img class="card-img-top course-img" src="{{asset('assets/aula/img/induccion.png')}}"
                                alt="Card image cap">
                            <div class="course-box-absolute">
                                <span class="course-title-box">
                                    {{$course->description}}
                                    <span class="extra-lines"></span>
                                </span>
                            </div>
                        </div>

                        <div class="start-button-box">

                            @if(Auth::user()->role == 'participants')
                            <a href="{{route('aula.course.participant.show', $course)}}">
                            @elseif(Auth::user()->role == 'instructor')
                            <a href="{{route('aula.course.instructor.show', $course)}}">
                                @endif
                                Comenzar
                                <i class="fa-solid fa-chevron-right"></i>
                            </a>
                        </div>

                        <div class="card-body">

                            <div class="course-instructor-box inner-box">

                                <div class="section-title">
                                    @if(count($instructors) == 1)
                                    Instructor
                                    @elseif(count($instructors) > 1)
                                    Instructores
                                    @endif
                                </div>
                                <div class="section-content instructor">
                                    @foreach ($instructors as $instructor)
                                    <span>
                                        {{strtolower($instructor->name)}} 
                                        {{strtolower($instructor->paternal)}} 
                                        {{strtolower($instructor->maternal)}}
                                    </span>
                                    @endforeach
                                    <div class="context-icon">
                                        <i class="fa-solid fa-user-tie"></i>
                                    </div>
                                </div>

                            </div>

                            <div class="course-hours-box inner-box">
                                <div class="section-title">
                                    Duración
                                </div>
                                <div class="section-content hours">
                                    <span>
                                        {{$course->hours}} 
                                        <span> Hrs. </span>
                                    </span>
                                    <div class="context-icon">
                                        <i class="fa-regular fa-clock"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="course-students-box inner-box">
                                <div class="section-title students">
                                    <span>
                                        # Alumnos
                                    </span>
                                </div>
                                <div class="section-content students">
                                    <span>
                                        {{getNStudentsFromCourse($course)}}
                                    </span>
                                    <div class="context-icon">
                                        <i class="fa-solid fa-graduation-cap"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    @empty

                    <h1> No hay Cursos que mostrar aún </h1>

                    @endforelse

                </div>

                {{-- <iframe
                    src="https://onedrive.live.com/embed?resid=8E4CB396B6F1A04F%21109&amp;authkey=!ABNpTMDwGLYKyaI&amp;em=2&amp;wdAr=1.7777777777777777"
                    width="1300px" height="1000px" frameborder="0">Esto es un documento de <a target="_blank"
                        href="https://office.com">Microsoft Office</a> incrustado con tecnología de <a target="_blank"
                        href="https://office.com/webapps">Office</a>.
                </iframe> --}}

            </div>
        </div>

    </div>
</div>

@endsection