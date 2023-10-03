@extends('admin.common.layouts.masterpage')

@section('content')

<div class="row content">


    <div class="main-container-page">
        <div class="card page-title-container">
            <div class="card-header">
                <div class="total-width-container">
                    <h4>Eventos</h4>
                </div>
            </div>
        </div>

        <div class="card-body card z-index-2 principal-container">


            <div class="group-filter-buttons-section">
                <div class="form-group date-range-container">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <a href="javascript:;" id="daterange-btn-events"
                                class="btn btn-primary icon-left btn-icon pt-2">
                                <i class="fas fa-calendar"></i>
                                Elegir Fecha
                            </a>
                        </div>
                        <input type="text" name="date-range" class="form-control date-range-input"
                            id="date-range-input-event" disabled>
                    </div>
                </div>
            </div>

            <div class="group-filter-buttons-section flex-wrap">
                <div class="form-group col-2 p-0 select-group">
                    <label class="form-label">Filtrar por curso: &nbsp;</label>
                    <div>
                        <select name="type" class="form-control select2 select-filter-event" id="search_from_course_select">
                            <option value=""> Todos </option>
                            @foreach ($courses as $course)
                            <option value="{{ $course->id }}"> {{ $course->id }} - {{ $course->description }} </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group col-2 p-0 select-group">
                    <label class="form-label">Filtrar por Instructor: &nbsp;</label>
                    <div>
                        <select name="type" class="form-control select2 select-filter-event" id="search_from_instructor_select">
                            <option value=""> Todos </option>
                            @foreach ($instructors as $instructor)
                            <option value="{{ $instructor->id }}"> {{ $instructor->full_name }} </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group col-2 p-0 select-group">
                    <label class="form-label">Filtrar por Responsable: &nbsp;</label>
                    <div>
                        <select name="type" class="form-control select2 select-filter-event" id="search_from_responsable_select">
                            <option value=""> Todos </option>
                            @foreach ($responsables as $responsable)
                            <option value="{{ $responsable->id }}"> {{ $responsable->full_name }} </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <button class="btn btn-primary" id="btn-register-event-modal"
                    data-url="{{ route('admin.events.create') }}">
                    <i class="fa-solid fa-square-plus"></i> &nbsp; Registrar
                    <i class="fa-solid fa-spinner fa-spin loadSpinner ms-1"></i>
                </button>
            </div>

            <table id="events-table" class="table table-hover" data-url="{{ route('admin.events.index') }}">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Descripción</th>
                        <th>Tipo</th>
                        <th>Fecha</th>
                        <th>Curso</th>
                        <th>Instructor</th>
                        <th>Responsable</th>
                        <th>Asistencias</th>
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

@include('admin.events.partials._modal_store_event')

@include('admin.events.partials._modal_edit_event')

@endsection