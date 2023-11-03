<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>@yield('title', 'ADP | Technology')</title>

    <style>
        * {
            padding: 0;
            margin: 0;
            font-size: 0.95rem;
            font-family: Arial, Helvetica, sans-serif;
            line-height: 1.3em;
            box-sizing: border-box;
        }

        body {margin: 1.2cm;}
        table {border-collapse: collapse;}

        .text-center {text-align: center;}
        .text-left {text-align: left;}
        .text-right {text-align: right;}
        .text-bold {font-weight: bold;}
        .capitalize {text-transform: capitalize;}
        .m-0 {margin: 0;}
        .mt-1 {margin-top: 0.25em;}
        .mt-2 {margin-top: 0.5em;}
        .mt-3 {margin-top: 0.75em;}
        .ms-1 {margin-left: 0.25em;}
        .ms-2 {margin-left: 0.5em;}
        .ms-3 {margin-left: 0.75em;}
        .me-1 {margin-right: 0.25em;}
        .me-2 {margin-right: 0.5em;}
        .me-3 {margin-right: 0.75em;}
        .mb-1 {margin-bottom: 0.25em;}
        .mb-2 {margin-bottom: 0.5em;}
        .mb-3 {margin-bottom: 0.75em;}
        .f-left {float: left;}
        .f-right {float: right;}
        .f-clear {clear: both;}
        .w-half {width: 9.3cm}
        .w-100 {width: 18.6cm;}
        .p-0 {padding: 0;}
        .p-1 {padding: 0.15cm;}
        .pt-1 {padding-top: 0.15cm;}
        .pb-1 {padding-bottom: 0.15cm;}
        .p-2 {padding: 0.5em;}
        .bg-dark {background-color: rgb(66, 66, 66);}
        .bg-primary {background-color: rgb(83, 175, 190);}
        .text-white {color: white;}
        .border {border: 1px solid rgb(66, 66, 66);}
        .border-top {border-top: 1px solid rgb(66, 66, 66);}
        .border-bottom {border-bottom: 1px solid rgb(66, 66, 66);}
        .ms-auto {margin-left: auto;}
        .text-success {color: green;}
        .text-error {color: rgb(221, 0, 0);}
        .pos-relative {position: relative;}
        .w-100-p1 {width: 18.4cm;}
        .w-half-p1 {width: 9.1cm;}
        .w-third-p1 {width: 6.1cm;}
        .w-70-p1 {width: 12.9cm;}
        .w-30-p1 {width: 5.5cm;}
        .d-block {display: block;}

        .bg-selected {background-color: rgba(255, 201, 25, 0.438);}
        .not-page-break {page-break-inside: avoid;}
        .detail-header {padding: 3px;}

        .img-container{
            overflow: hidden;
        }

        .img-container img{
            height: 2.4cm;
        }

        .icon-container {
            display: table-cell;
        }

        .relation-icon {
            position: relative;
            width: 5cm;
            height: .2cm;
            margin: auto;
            background-color: rgb(216, 216, 216);
        }

        .relation-icon::after,
        .relation-icon::before
        {
            content: '';
            position: absolute;
            width: .5cm;
            height: .5cm;
            top: 50%;
            transform: translateY(-50%);
            border-radius: 50%;
            background-color: rgb(216, 216, 216);
        }

        .relation-icon::after {
            left: 0;
        }

        .relation-icon::before {
            right: 0;
        }

    </style>

</head>

@php
$user = $certification->user;
$event = $certification->event;
$evaluations = $certification->evaluations;
@endphp

<body>

    <h3 class="text-center mb-3">
        <u>REPORTE DE EVALUACIÓN N° {{$certification->id}}</u>
    </h3>

    <div class="header">

        <div>
            <div class="w-half f-left">
                <div>
                    <b>Evento: </b>
                    {{$event->description}}
                </div>
            </div>

            <div class="w-half f-left text-right">
                <b>Fecha: </b>
                {{$event->date}}
            </div>
        </div>

        <div class="f-clear capitalize">
            <div class="w-half f-left ">
                <b>Curso: </b>
                {{ mb_strtolower($event->course->description, 'UTF-8') }}
            </div>
            <div class="w-half f-left text-right">
                <b>Examen: </b>
                {{ mb_strtolower($event->exam->title, 'UTF-8') }}
            </div>
        </div>

        <div class="f-clear">
            <div class="w-half f-left">
                <b>Hora de inicio: </b>
                {{$certification->start_time}}
            </div>
            <div class="w-half f-left text-right">
                <b>Hora de finalización: </b>
                {{$certification->end_time}}
            </div>
        </div>

        <div class="f-clear">
            <div class="w-half f-left">
                <b>Tiempo total: </b>
                {{$certification->total_time}} min.
            </div>
            <div class="w-half f-left text-right">
                <b>Nota mínima: </b>
                {{$event->min_score}} puntos
            </div>
        </div>

        @if ($certification->recovered_at != '')

        <div class="f-clear">
            <div class="w-half f-left">
                <b>Fecha de recuperación: </b>
                {{$certification->recovered_at}}
            </div>
        </div> 

        @endif
    </div>

    {{-- PARTICIPANT DETAILS --}}

    <div class="container-detail f-clear">

        <div class="detail-header text-white bg-primary text-center text-bold mb-1 mt-3">
            DETALLE DEL ALUMNO
        </div>

        <div class="p-1">

            <div>
                <div class="f-left w-half-p1">
                    <b>DNI: </b>
                    {{ $user->dni }}
                </div>
                <div class="f-left w-half-p1 text-right">
                    <b>Teléfono: </b>
                    {{ $user->telephone }}
                </div>
            </div>

            <div class="f-clear">
                <div class="f-left w-half-p1 capitalize">
                    <b>Nombre: </b>
                    {{ mb_strtolower($user->full_name_complete, 'UTF-8') }}
                </div>
                <div class="f-left w-half-p1 text-right">
                    <b>Cargo: </b>
                    {{ $user->position ?? '-' }}
                </div>
            </div>

            <div class="f-clear">
                <div class="f-left w-half-p1">
                    <b>Correo: </b>
                    {{ $user->email }}
                </div>
                <div class="f-left w-half-p1 text-right">
                    <b>Perfil de usuario: </b>
                    {{ $user->profile_user ?? '-' }}
                </div>
            </div>

        </div>
    </div>

    {{-- EVALUATION DETAILS --}}

    <div class="f-clear">
        <div class="detail-header bg-primary text-white text-center text-bold mb-1 mt-3">
            DETALLE DE LA EVALUACIÓN
        </div>
    </div>

    <div class="p-1">
        @foreach ($evaluations as $evaluation)
        @php
        $question = $evaluation->question;
        $type = $question->question_type_id;
        @endphp
        <div class="not-page-break f-clear">

            <div class="text-bold border-top mt-3">
                <div class="w-half-p1 f-left mb-1">
                    <i>Enunciado N° {{ $loop->iteration }}</i>
                </div>
                <div class="w-half-p1 f-left text-right">
                    <i> {{$question->points}} puntos</i>
                </div>
            </div>

            <div class="border-top f-clear pt-1 pb-1">
                <div class="text-center ">
                    {{ $question->statement }}
                </div>
                <div>

                    @if (in_array($type, ['1','2','3']))
                    @php
                    $selected_alt = explode(',', $evaluation->selected_alternatives);
                    @endphp
                    <div>
                        Alernativas:
                    </div>
                    @foreach ($question->alternatives as $alternative)
                    <div class="w-100-p1">
                        <div>
                            {{$loop->iteration }})&nbsp;
                            <span class="@if(in_array($alternative->id, $selected_alt)) bg-selected @endif">
                                {{ $alternative->description }}
                            </span>
                            @if ($alternative->is_correct == 1)
                            <span class="text-success" style="font-family: DejaVu Sans, sans-serif;">
                                &check;
                            </span>
                            @endif
                        </div>
                    </div>
                    @endforeach
                    @elseif(in_array($type, ['4']))
                    @php
                    $entered_answers = getCleanArrayAnswers($evaluation->selected_alternatives);
                    @endphp
                    <div class="mt-3">
                        @foreach ($question->alternatives as $alternative)
                        <div class="w-100-p1">
                            <div>
                                Respuesta(s) correcta(s) #{{$loop->iteration }}:&nbsp;
                                <span>
                                    {{ mb_strtoupper($alternative->description, 'UTF-8') }}
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="mt-3">
                        @foreach ($entered_answers as $answer)
                        <div>
                            Respuesta ingresada #{{$loop->iteration}}:&nbsp;
                            {{ $answer }}
                        </div>
                        @endforeach
                    </div>
                    @elseif(in_array($type, ['5']))
                    <table class="mt-2">
                        <tbody>
                            @php
                            $related_answers = explode(',', $evaluation->selected_alternatives);
                            @endphp
                            @foreach ($related_answers as $related_answer)
                            @php
                            $answer = explode(':', $related_answer);
                            $alternative = $question->alternatives->where('id', $answer[1])->first();
                            $droppable = $question->droppableOptions->where('id', $answer[0])->first();
                            @endphp
                            <tr>
                                <td class="text-center w-third-p1 border-bottom border-top pb-1">
                                    <div>
                                        {{ $alternative->description }}
                                    </div>
                                    @if ($alternative->file)
                                    <div class="img-container">   
                                        <img src="{{ verifyImage($alternative->file) }}">
                                    </div>
                                    @endif
                                </td>
                                <td class="w-third-p1 text-center border-bottom border-top icon-container">
                                    <div class="relation-icon">
                                    </div>
                                </td>
                                <td class="text-right w-third-p1 border-bottom border-top">
                                    <span class="me-1">
                                        {{ $droppable->description }}
                                    </span>
                                    @if ($alternative->droppableOption->id == $answer[0])
                                    <span class="text-success" style="font-family: DejaVu Sans, sans-serif; font-size:1.7em;">
                                        &check;
                                    </span>
                                    @else
                                    <span class="text-error" style="font-family: DejaVu Sans, sans-serif; font-size:1.7em;">
                                        &#x2717;
                                    </span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @endif

                    <div class="mt-3">
                        Puntos: {{ round($evaluation->points ?? 0, 1)}}
                    </div>

                </div>
            </div>

        </div>

        @endforeach
    </div>

    {{------ RESULTS ------}}

    <div class="f-clear not-page-break">

        <div class="detail-header bg-primary text-white text-center text-bold mb-1 mt-3">
            RESULTADOS
        </div>

        <div>
            <div class="w-half f-left">
                <div>
                    <b>Puntuación final: </b>
                    {{$certification->score}}
                </div>
            </div>

            <div class="w-half f-left text-right">
                <b>Estado: </b>
                @if ($certification->score >= $event->min_score)
                Aprobado
                @else
                Desaprobado
                @endif
            </div>
        </div>

    </div>

</body>

</html>