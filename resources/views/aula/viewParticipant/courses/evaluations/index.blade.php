@extends('aula.common.layouts.masterpage')

@section('content')

<div class="content global-container">

    <div class="card page-title-container">
        <div class="card-header">
            <div class="total-width-container">
                <h4>
                    <a href="{{route('aula.course.index')}}">
                        <i class="fa-solid fa-circle-chevron-left"></i> Cursos
                    </a>
                    <span> / {{$course->description}} </span> /
                    <a href="{{route('aula.course.participant.show', $course)}}">
                        MENÚ
                    </a> /
                    EVALUACIONES
                </h4>
            </div>
        </div>
    </div>

    <div class="mt-5 card-body body-global-container card z-index-2 principal-container">

        <div class="courses-cards-container">

            @foreach($certifications as $certification)

            @php
            
            updateIfNotFinished($certification);
            $ownerCompany = $certification->event->exam->ownerCompany;
            $event = $certification->event;
            $status = $certification->status;
            $availableStart = getCurrentDate() == $event->date && 
                                $certification->status == 'pending' && 
                                $certification->assist_user == 'S' ? true : false;

            @endphp

            <div class="card evaluation-card">
                <div class="evaluation-card-head-box">
                    @if ($status == 'finished')
                    <span class="evaluation-bg"></span>
                    @endif

                    <div class="event-title @if($status == 'finished')finished @endif">
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
                                @if($status == 'finished')
                                Finalizado
                                @elseif($status == 'in_progress')
                                En progreso
                                @elseif($status == 'pending')
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

                        @if ($availableStart)

                        <!-- Button trigger modal -->
                        <button type="button" class="btn variable-info btn-evaluation-start" data-toggle="modal"
                            data-target="#instructions-modal" data-send='{{route('aula.course.ajax.certification',
                            $certification)}}' data-url="{{route('aula.course.quiz.start', $certification)}}">
                            Iniciar &nbsp;
                            <i class="fa-solid fa-chevron-right"></i>
                        </button>

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

                        @elseif ($status == 'finished')

                        @if ($certification->score < $event->min_score) <div class="variable-info" style="color: rgb(189, 20, 20)">
                            Desaprobado &nbsp;
                            <i class="fa-regular fa-circle-xmark"></i>
                    </div>
                    @else
                    <div class="variable-info" style="color: rgb(48, 189, 20)">
                        Aprobado &nbsp;
                        <i class="fa-regular fa-circle-check"></i>
                    </div>
                    @endif

                    @elseif($certification->assist_user == 'N')

                    <div class="variable-info" style="background-color: rgba(189, 20, 20, 0.486)">
                        No se ha marcado asistencia &nbsp;
                        <i class="fa-solid fa-calendar-xmark"></i>
                    </div>

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







@section('modals')

<!-- START QUIZ MODAL -->

<div class="modal fade" id="instructions-modal" tabindex="-1" aria-labelledby="instructionsModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="instructionsModalLabel">
                    CARACTERÍSTICAS DE LA EVALUACIÓN
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="subtitle">
                    Lea las siguientes instrucciones antes de comenzar la evaluación:
                </div>

                <ul>
                    <li>
                        Tiempo de examen <span class="ev-time"></span> minutos, <span class="qst-time"></span> minutos
                        por pregunta.
                    </li>
                    <li>
                        Una vez comenzado el examen debe permanecer en la página.
                    </li>
                    <li>
                        No abrir o visualizar otras páginas mientras está desarrollando la evaluación, ya que la
                        plataforma lo detectará como inactividad y cerrará la sesión automáticamente.
                    </li>
                    <li>
                        Trabaje individualmente y no use su teléfono celular o páginas web para responder esta
                        evaluación.
                    </li>
                </ul>
            </div>
            <div class="modal-footer">

                <form method="POST" class="evaluation-start-form">
                    @csrf
                    <button type="button" class="btn btn-close" data-dismiss="modal">Cerrar</button>
                    <button type="submit" id="btn-start-evaluation" class="btn btn-send">Comenzar Examen</button>

                </form>

            </div>
        </div>
    </div>
</div>


@endsection