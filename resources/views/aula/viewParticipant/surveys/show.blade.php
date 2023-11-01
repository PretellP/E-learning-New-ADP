@extends('aula.common.layouts.masterpage')


@section('content')

<div class="content global-container">

    <div class="card page-title-container">
        <div class="card-header">
            <div class="total-width-container">
                <h4>Encuesta: {{$survey->name}}</h4>
            </div>
        </div>
    </div>

   
    <div class="card-body body-global-container surveys card z-index-2 principal-container">

        @if ($user_survey->event)

        <div class="mb-4">
            <div>
                <span class="h5">Curso:</span>
                 {{ $user_survey->event->course->description }}
            </div>
            <div>
                <span class="h5">Evento:</span>
                 {{ $user_survey->event->description }}
            </div>
        </div>
            
        @endif

        <div class="step-survey-container">

            @if ($survey->destined_to == 'course_live')
                @include('aula.viewParticipant.surveys.types._course_live')
            @else
                @include('aula.viewParticipant.surveys.types._select_multiple')
            @endif

        </div>

    </div>

</div>


@endsection