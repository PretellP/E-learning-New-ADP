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