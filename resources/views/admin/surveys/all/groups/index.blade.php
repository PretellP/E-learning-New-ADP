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
                <a href="{{route('admin.surveys.all.index')}}">Inicio</a>
                / Encuesta:
                <a href="{{ route('admin.surveys.all.show', ["survey" => $group->survey]) }}">
                    {{ $group->survey->name }}
                </a>
                / Grupo:
                <span id="group-name-text-principal">
                    {{ $group->name }}
                </span>
            </h5>

            <div id="group-box-container" class="info-element-box mt-4 mb-3">

                @include('admin.surveys.partials.boxes._group')

            </div>

            <hr>

            <div class="principal-splitted-container mt-1 mb-2">

                <div class="principal-inner-container total-width">

                    <div class="inner-title-container">
                        <div class="btn-dropdown-container show">
                            <h5 class="title-header-show"> Creación de preguntas </h5>
                            
                            <div class="btn-row-container">
                                <div>
                                    <span class="text-dropdown-cont">
                                        Ocultar
                                    </span>
                                    <i class="fa-solid fa-chevron-down ms-2"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="dropdown-statement-create" class="related-dropdown-container">

                        <form id="registerStatementForm" action="{{ route('admin.surveys.all.groups.statement.store', $group) }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="form-row">
                                <div class="form-group col-12 col-md-6">
                                    <label>Pregunta *</label>
                                    <input type="text" name="description" class="form-control">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12 col-md-6">
                                    <label>Descripción (opcional)</label>
                                    <input type="text" name="desc" class="form-control">
                                </div>
                            </div>

                            <div class="form-row questionTypeSelect">
                                <div class="form-group col-12">
                                    <label>Tipo de respuesta *</label>
                                    <div class="input-group">
                                        <select name="type" class="form-control select2"
                                            id="registerStatementTypeSelect"
                                            data-url="{{ route('admin.surveys.all.groups.statements.getType', $group) }}">
                                            <option></option>
                                            @foreach (config('parameters.statement_type') as $key => $type)
                                            <option value="{{ $key}}"> {{ $type }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div id="options-type-container">
                                
                            </div>

                            <div class="total-width text-left">
                                <button type="submit" class="btn btn-primary btn-save">
                                    Guardar
                                    <i class="fa-solid fa-spinner fa-spin loadSpinner ms-1"></i>
                                </button>
                            </div>

                        </form>

                    </div>

                </div>

            </div>

            <hr>


            <h5 class="title-header-show mb-4">
                Lista de preguntas:
            </h5>

            <table id="statements-table" class="table table-hover"
                data-url="{{ route('admin.surveys.all.groups.statements.index', $group) }}">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Pregunta</th>
                        <th>Tipo de respuesta</th>
                        <th>Fecha de creación</th>
                        <th>Fecha de actualización</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>

    </div>

</div>

@endsection

@section('modals')

@include('admin.surveys.partials.modals._edit_group', ["show" => "show"])
    
@endsection