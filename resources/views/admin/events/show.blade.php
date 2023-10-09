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

            <h5 class="title-header-show">
                <i class="fa-solid fa-chevron-left fa-xs"></i>
                <a href="{{route('admin.events.index')}}">Inicio</a>
                / Evento:
                <span id="event-description-text-principal" class="to-capitalize">
                    {{ mb_strtolower($event->description, 'UTF-8') }}
                </span>
            </h5>

            
            <div id="event-box-container" class="info-element-box event-box mt-4 mb-3">

                @include('admin.events.partials._box_event')
  
            </div>


            <h5 class="title-header-show mb-4 mt-4"> Lista de participantes: </h5>

            <div class="mb-4">
                <button class="btn btn-primary" id="btn-register-participant-modal" data-url="">
                    <i class="fa-solid fa-square-plus"></i> &nbsp; Registrar participantes
                    <i class="fa-solid fa-spinner fa-spin loadSpinner ms-1"></i>
                </button>
            </div>

            <table id="certifications-table" class="table table-hover"
                data-url="{{ route('admin.events.show', $event) }}">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>DNI</th>
                        <th>Participante</th>
                        <th>Empresa</th>
                        <th>Nota</th>
                        <th>Estado</th>
                        <th>Habilitado</th>
                        <th>Asistencia</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>

        </div>

    </div>

</div>

@endsection

@section('modals')

@include('admin.events.partials._modal_edit_event', ["show" => 'show'])

@include('admin.events.partials._modal_store_participant')

@include('admin.events.partials._modal_show_certification')

@include('admin.events.partials._modal_edit_certification')

@endsection