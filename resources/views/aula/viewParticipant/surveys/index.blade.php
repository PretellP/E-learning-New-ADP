@extends('aula.common.layouts.masterpage')

@section('content')

<div class="content global-container">

    <div class="card page-title-container">
        <div class="card-header">
            <div class="total-width-container">
                <h4>Encuestas</h4>
            </div>
        </div>
    </div>

    <div class="card-body body-global-container surveys card z-index-2 principal-container">

        <div class="info-count-courses">
            Tienes <span> {{count($pendingSurveys)}} </span> encuestas pendientes
        </div>

        <div class="courses-cards-container">

            @forelse ($pendingSurveys as $userSurvey)

            <div class="survey-container">
                <div class="survey-img-container">
                    <img class="card-img-top survey-img" src="{{verifyImage($userSurvey->survey->file)}}"
                        alt="Card image cap">
                </div>

                <div class="card-body survey">

                    <div class="survey-title-box">
                        {{$userSurvey->survey->name}}
                    </div>

                    @if ($userSurvey->event)
                    <div class="text-center">
                        <div>
                            <span class="font-weight-bold">Curso: </span>
                            <span> {{ $userSurvey->event->course->description }} </span>
                        </div>
                        <div>
                            <span class="font-weight-bold">Evento: </span>
                            <span> {{ $userSurvey->event->description }} </span>
                        </div>
                    </div>
                    @endif

                    <div class="survey-btn-start">
                        <a href="" onclick="event.preventDefault();
                            document.getElementById('survey-start-form-{{$userSurvey->id}}').submit();">
                            Responder &nbsp;
                            <i class="fa-solid fa-chevron-right"></i>
                        </a>
                        <form id="survey-start-form-{{$userSurvey->id}}" action="{{route('aula.surveys.start', $userSurvey)}}" method="GET">
                        </form>
                    </div>

                </div>

            </div>

            @empty

            <h4>No tienes encuestas pendientes</h4>

            @endforelse


        </div>

        

    </div>

</div>


@endsection