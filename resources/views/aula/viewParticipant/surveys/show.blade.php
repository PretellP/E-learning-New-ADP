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

        <div class="step-survey-container">

            @if ($survey->destined_to == 'course_live')
                @include('aula.viewParticipant.surveys.types.groupable')
            @else
                @include('aula.viewParticipant.surveys.types.ungrouped')
            @endif

        </div>

    </div>

</div>


@endsection