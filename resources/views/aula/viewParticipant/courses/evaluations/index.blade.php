@extends('aula.common.courses.layout')

@section('page-info', 'Evaluaciones')

@section('courseContent')

<div class="link-navigation-pages mt-4">
    <a href="{{route('aula.course.index')}}">
        <i class="fa-solid fa-arrow-left"></i>
        Volver a los cursos
    </a>
    <a href="{{route('aula.course.participant.show', $course)}}">
        / Menú
    </a>

    / Evaluaciones
</div>


<div class="row mt-5 w-100">

    <div class="course-container">

        @foreach($certifications as $certification)

        @php
        updateIfNotFinished($certification);
        $ownerCompany = getOwnerCompanyFromCertification($certification);
        $event = $certification->event()->first();
        @endphp

        <div class="card evaluation-card">
            <div class="evaluation-card-head-box">
                <div class="event-title">
                    {{$event->description}}
                </div>
            </div>
            <div class="evaluation-card-body-box">

                <div class="info-container">
                    <div class="evaluation-text-cont-box">
                        <span class="subtitle-text">
                            Titular
                        </span>
                        <span class="content-text">
                            {{$ownerCompany->name}}
                        </span>
                    </div>

                    <div class="evaluation-text-cont-box">
                        <span class="subtitle-text">
                            Estado
                        </span>
                        <span class="content-text">
                            @if($certification->status == 'finished')
                            Finalizado
                            @elseif($certification->status == 'in_progress')
                            En progreso
                            @elseif($certification->status == 'pending')
                            Pendiente
                            @endif
                        </span>

                    </div>

                    <div class="evaluation-text-cont-box">

                        <span class="subtitle-text">
                            Fecha
                        </span>
                        <span class="content-text">
                            {{$event->date}}
                        </span>

                    </div>
                </div>

                <div class="state-start-info">

                    @if (getCurrentDate() == $event->date && $certification->status == 'pending')
                    <a class="variable-info" href="" onclick="event.preventDefault();
                        document.getElementById('quiz-start-form').submit();">
                        Iniciar &nbsp;
                        <i class="fa-solid fa-chevron-right"></i>
                    </a>
                    <form id="quiz-start-form" method="POST"
                        action="{{route('aula.course.quiz.start', $certification)}}">
                        @csrf
                    </form>

                    @elseif ($certification->status == 'in_progress')

                    <a style="background-color: rgb(250, 135, 68)" class="variable-info" href="" onclick="event.preventDefault();
                                    document.getElementById('quiz-start-form').submit();">
                        Continuar &nbsp;
                        <i class="fa-solid fa-chevron-right"></i>
                    </a>
                    <form id="quiz-start-form" method="POST"
                        action="{{route('aula.course.quiz.start', $certification)}}">
                        @csrf
                    </form>

                    @elseif ($certification->status == 'finished')

                        @if ($certification->score < 10)
                            <div class="variable-info" style="background-color: rgb(189, 20, 20)">
                                Desaprobado &nbsp;
                                <i class="fa-regular fa-circle-xmark"></i>
                            </div>
                        @else
                            <div class="variable-info" style="background-color: rgb(48, 189, 20)">
                                Aprobado &nbsp;
                                <i class="fa-regular fa-circle-check"></i>
                            </div>
                        @endif

                    @else
                        
                        <div class="variable-info" style="background-color: rgba(189, 20, 20, 0.486)">
                            Fuera de Fecha &nbsp;
                            <i class="fa-solid fa-calendar-xmark"></i>
                        </div>

                    @endif

                </div>

            </div>
        </div>

        @endforeach

    </div>

</div>

@endsection