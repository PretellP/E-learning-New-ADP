@extends('aula.common.layouts.masterpage')

@section('content')

<div class="content global-container">

    <div class="card page-title-container free-courses">
        <div class="card-header">
            <div class="total-width-container">
                <h4>MI PROGRESO</h4>
            </div>
        </div>
    </div>

    <div class="card-body body-global-container progress-container card z-index-2 principal-container">

        <div class="progress-section-title-container">
            Mis Cursos
        </div>

        <div class="course-progress-container mb-6">
            @foreach ($courses as $course)
            @php
            $current_course = $course->first()->event->exam->course;
            @endphp
            <div class="course-box">
                <div class="course-progress-innerbox">
                    <div class="course-progress-img">
                        <img src="{{asset($current_course->url_img)}}" alt="">
                    </div>
                    <div class="course-progress-info">
                        <div class="title">
                            {{$current_course->description}}
                        </div>
                        <a class="btn-start"
                            href="{{route('aula.course.participant.show', ['course'=>$current_course])}}"
                            class="btn-start">
                            Ingresar
                        </a>
                        <div class="extra-info">
                            <i class="fa-regular fa-clock"></i> &nbsp;
                            Duración: {{$current_course->hours}} hrs.
                        </div>
                    </div>

                </div>

                <div class="progress-bar-line-box course-progress-assist">
                    <div class="info-progress-txt info-assist">
                        Tienes {{$course->where('assist_user', 'S')->count()}} de {{$course->count()}} asistencias
                    </div>
                    <div class="progress-line assist">
                        @foreach ($course as $certification)
                        @if ($certification->assist_user == 'S')
                        <div class="progress-bar assist"></div>
                        @else
                        <div class="progress-bar no-assist"></div>
                        @endif
                        @endforeach

                    </div>
                </div>

                <div class="progress-bar-line-box course-progress-evaluations">
                    <div class="info-progress-txt info-evaluations">
                        @php
                        $pe_count = $course->where('status', 'pending')->count();
                        @endphp
                        Tienes <span> {{$pe_count}} </span>
                        @if ($pe_count == 1)
                        evaluación pendiente
                        @else
                        evaluaciones pendientes
                        @endif
                    </div>
                    <div class="progress-line assist">
                        @foreach ($course->sortBy('id') as $evaluation)
                        @if ($evaluation->status == 'finished')
                        <div class="progress-bar finished"></div>
                        @elseif($evaluation->status == 'pending')
                        <div class="progress-bar pending"></div>
                        @endif
                        @endforeach
                    </div>
                </div>
                <div id='chart-{{$current_course->id}}' class="course-progress-results"
                    data-approved='{{$course->where('status', 'finished' )->where('score', '>=', 10)->count()}}'
                    data-suspended='{{$course->where('status', 'finished')->where('score', '<', 10)->count()}}'>
                        <div class="progress-evaluation-title">Resultados</div>
                        <span class="progress-evaluation-subtitle">
                            @php
                            $evaluations_count = $course->where('status', 'finished')->count();
                            @endphp
                            @if ($evaluations_count == 1)
                            {{$evaluations_count}} Evaluación total
                            @else
                            {{$evaluations_count}} Evaluaciones totales
                            @endif
                        </span>
                        <canvas class="canva-progress" id="progress-chart-{{$current_course->id}}"></canvas>
                </div>
            </div>
            @endforeach

        </div>


        <div class="progress-section-title-container">
            Mis Cursos libres
        </div>

        <div class="course-progress-container mb-6">
            @foreach ($freeCourses as $freeCourse)
            @php
                $currentFreeCourse = $freeCourse->first()->courseSection->course;
                $totalChapters = getFreeCourseTotalChapters($currentFreeCourse);
                $completedChapters = getCompletedChapters($freeCourse);
            @endphp
            <div class="course-box">
                <div class="course-progress-innerbox">
                    <div class="course-progress-img">
                        <img src="{{asset($currentFreeCourse->url_img)}}" alt="">
                    </div>
                    <div class="course-progress-info">
                        <div class="title">
                            {{$currentFreeCourse->description}}
                        </div>
                        <a class="btn-start" href="" onclick="event.preventDefault();
                        document.getElementById('freecourse-start-form').submit();" class="btn-start">
                            Ingresar
                        </a>
                        <form id='freecourse-start-form' method="POST" action="{{route('aula.freecourse.start', ["course" => $currentFreeCourse])}}#chapter-title-head"> 
                            @csrf 
                        </form>
                        <div class="extra-info">
                            <i class="fa-regular fa-clock"></i> &nbsp;
                            Duración: {{getFreeCourseTime($currentFreeCourse)}}
                        </div>
                    </div>
                </div>

                <div class="freecourse-progress-results" >
                    <div id='chart-{{$currentFreeCourse->id}}' class="freecourse-progress-chart-box" 
                        data-total='{{$totalChapters - $completedChapters}}' data-completed='{{$completedChapters}}'>
                        <canvas class="freecourse-chart" id="freecourse-chart-{{$currentFreeCourse->id}}"></canvas>
                    </div>
                    <div class="freecourse-progress-percentage-box">
                        <div class="txt-perc-info">
                            <span>
                                {{round(($completedChapters/$totalChapters)*100)}}%
                            </span>
                                &nbsp; COMPLETADO
                        </div>
                    </div>
                </div>

                

                <div class="progress-bar-line-box course-progress-assist">
                    <div class="info-progress-txt info-assist">
                        {{$completedChapters}} de {{$totalChapters}} capítulos finalizados
                    </div>
                    <div class="freecourse-progress-line-container">
                        @for ($i = 0; $i < $totalChapters; $i++)
                        @if ($i < $completedChapters)
                        <div class="freecourse-progress-line completed">
                        </div>
                        @else
                        <div class="freecourse-progress-line pending">
                        </div>
                        @endif
                        @endfor
                    </div>

                </div>
                
            </div>
            @endforeach



        </div>

    </div>

</div>


@endsection

@section('extra-script')

<script src="{{asset('assets/aula/js/charts.js')}}"></script>

@endsection