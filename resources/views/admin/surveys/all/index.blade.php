@extends('admin.common.layouts.masterpage')

@section('content')

<div class="row content">


    <div class="main-container-page">
        <div class="card page-title-container">
            <div class="card-header">
                <div class="total-width-container">
                    <h4>Encuestas</h4>
                </div>
            </div>
        </div>

        <div class="card-body card z-index-2 principal-container">

            <div class="mb-4">
                <button class="btn btn-primary" data-toggle="modal" data-target="#RegisterSurveyModal">
                    <i class="fa-solid fa-square-plus"></i> &nbsp; Registrar
                </button>
            </div>

            <table id="surveys-table" class="table table-hover" data-url="{{route('admin.surveys.all.index')}}">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Nombre</th>
                        <th>Destinado para</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>
            
        </div>

    </div>

</div>

@endsection

@section('modals')

@include('admin.surveys.partials.modals._create_survey')
@include('admin.surveys.partials.modals._edit_survey')

@endsection

