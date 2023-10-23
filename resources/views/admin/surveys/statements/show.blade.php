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

        <div id="dropdown-questions-create" class="card-body card z-index-2 principal-container">

            <h5 class="title-header-show">
                <i class="fa-solid fa-chevron-left fa-xs"></i>
                <a href="{{route('admin.surveys.index')}}">Inicio</a>
                / Encuesta:
                <a href="{{ route('admin.surveys.show', ["survey" => $statement->group->survey]) }}">
                    {{ $statement->group->survey->name }}
                </a>
                / Grupo:
                <a href="{{ route('admin.surveys.groups.show', ["group" => $statement->group]) }}">
                    {{ $statement->group->name }}
                </a>
                / Pregunta:
                <span id="title-statement-container">
                    {{ $statement->description }}
                </span>
            </h5>

            <hr>

            <form id="updateStatementForm" action="{{ route('admin.surveys.groups.statements.update', $statement) }}" method="POST">
                @csrf

                <input type="hidden" id="registerStatementTypeSelect" name="type" value="{{ $statement->type }}">

                <div class="form-row">
                    <div class="form-group col-12 col-md-6">
                        <label>Pregunta *</label>
                        <input type="text" name="description" class="form-control" value="{{ $statement->description }}">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-12 col-md-6">
                        <label>Descripción (opcional)</label>
                        <input type="text" name="desc" class="form-control" value="{{ $statement->desc ?? '-' }}">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-12">
                        <label>Tipo de pregunta</label>
                        <div class="form-control input-disabled">
                            {{ config('parameters.statement_type')[$statement->type] }}
                        </div>
                    </div>
                </div>

                <div id="options-type-container">

                    @if ($statement->type === 'select_multi')
                        @if ($statement->group->survey->destined_to === 'course_live')
                            @include('admin.surveys.partials.boxes._course_live', ["statement" => $statement])
                        @else   
                            @include('admin.surveys.partials.boxes._select_multi', ["statement" => $statement])
                        @endif
                    @endif

                </div>

                <div class="total-width text-left">
                    <button type="submit" class="btn btn-primary btn-save">
                        Guardar
                        <i class="fa-solid fa-spinner fa-spin loadSpinner ms-1"></i>
                    </button>
                </div>

            </form>

            <hr>
   
        </div>

    </div>

</div>

@endsection
