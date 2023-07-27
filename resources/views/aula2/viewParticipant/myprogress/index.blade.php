@extends('aula2.common.layouts.masterpage')

@section('content')

<div class="content global-container">

    <div class="card page-title-container free-courses">
        <div class="card-header">
            <div class="total-width-container">
                <h4>MI PROGRESO</h4>
            </div>
        </div>
    </div>

    <div class="card-body body-global-container progress-container card z-index-2 g-course-flex">

        <div class="progress-section-title-container">
            Mis Cursos
        </div>

        <div class="course-progress-container">
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
                    <div class="progress-evaluation-title">Evaluaciones</div>
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

    </div>

</div>


@endsection

@section('extra-script')

<script src="{{asset('assets/aula2/js/charts.js')}}"></script>

@endsection