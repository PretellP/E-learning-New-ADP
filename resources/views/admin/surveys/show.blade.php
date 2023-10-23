@extends('admin.common.layouts.masterpage')

@section('content')

<div class="row content">

    <div class="main-container-page">

        <div class="card page-title-container">
            <div class="card-header">
                <div class="total-width-container">
                    <h4>ENCUESTAS</h4>
                </div>
            </div>
        </div>

        <div class="card-body card z-index-2 principal-container">

            <h5 class="title-header-show">
                <i class="fa-solid fa-chevron-left fa-xs"></i>
                <a href="{{route('admin.surveys.index')}}">Inicio</a>
                / Encuesta:
                <span id="survey-name-text-principal">
                    {{ $survey->name }}
                </span>
            </h5>

            <div id="survey-box-container" class="info-element-box survey mt-4 mb-4">

                @include('admin.surveys.partials.boxes._survey', $survey)

            </div>


            <h5 class="title-header-show mb-4 mt-4"> Grupos de preguntas: </h5>

            <div class="mb-4">
                <button class="btn btn-primary" data-target="#RegisterSurveyGroupModal" data-toggle='modal'>
                    <i class="fa-solid fa-square-plus"></i> &nbsp; Añadir grupo de preguntas
                    <i class="fa-solid fa-spinner fa-spin loadSpinner ms-1"></i>
                </button>
            </div>

            <table id="groups-statements-table" class="table table-hover"
                data-url="{{ route('admin.surveys.groups.index', $survey) }}">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Grupo de preguntas</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>

        </div>

    </div>

</div>

@endsection

@section('modals')

@include('admin.surveys.partials.modals._edit_survey', ["show" => "show"])
@include('admin.surveys.partials.modals._create_group')
@include('admin.surveys.partials.modals._edit_group')

@endsection