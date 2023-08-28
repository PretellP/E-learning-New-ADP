@extends('admin.common.layouts.masterpage')

@section('content')

<div class="row content">


    <div class="main-container-page">
        <div class="card page-title-container">
            <div class="card-header">
                <div class="total-width-container">
                    <h4>SALAS</h4>
                </div>
            </div>
        </div>

        <div class="card-body card z-index-2 principal-container">

            <div class="mb-4">
                <button class="btn btn-primary" data-toggle="modal" data-target="#RegisterRoomModal">
                    <i class="fa-solid fa-square-plus"></i> &nbsp; Registrar
                </button>
            </div>

            <table id="rooms-table" class="table table-hover" data-url="{{route('admin.rooms.index')}}">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Nombre</th>
                        <th>Capacidad</th>
                        <th>Fecha de registro</th>
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

<div class="modal fade" id="RegisterRoomModal" tabindex="-1" aria-labelledby="RegisterRoomModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="RegisterCompanyModalLabel">
                    <div class="section-title mt-0">
                        <i class="fa-solid fa-square-plus"></i> &nbsp;
                        Registrar Sala
                    </div>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{route('admin.rooms.store')}}" id="registerRoomForm" method="POST" data-validate='{{route('admin.rooms.registerValidateName')}}'>
                @csrf

                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputRoomName">Nombre *</label>
                            <input type="text" name="name" class="form-control name"
                                placeholder="Ingresa nombre de la sala">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="inputPassword">Capacidad *</label>
                            <input type="number" name="capacity" class="form-control" step="1"
                                onkeypress="return(event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))"
                                placeholder="Ingresa capacidad">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="inputEmail">URL (opcional)</label>
                            <input name="url" type="text" class="form-control"
                                    placeholder="Ingrese url">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="custom-switch mt-2">
                            <input type="checkbox" name="roomStatusCheckbox" id="register-room-status-checkbox"
                                checked class="custom-switch-input">
                            <span class="custom-switch-indicator"></span>
                            <span id="txt-register-description-room" class="custom-switch-description">Activo</span>
                        </label>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-close" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary btn-save">
                        Guardar
                        <i class="fa-solid fa-spinner fa-spin loadSpinner ms-1"></i>
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>



<div class="modal fade" id="EditRoomModal" tabindex="-1" aria-labelledby="EditRoomModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="EditRoomModalLabel">
                    <div class="section-title mt-0">
                        <i class="fa-solid fa-square-plus"></i> &nbsp;
                        Editar Sala
                    </div>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="editRoomForm" method="POST" data-validate='{{route('admin.rooms.editValidateName')}}'>
                @csrf

                <input type="hidden" name="id">
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputRoomName">Nombre *</label>
                            <input type="text" name="name" class="form-control name"
                                placeholder="Ingresa nombre de la sala">
                        </div>

                        <div class="form-group col-md-6">
                            <label>Capacidad *</label>
                            <input type="number" name="capacity" class="form-control" step="1"
                                onkeypress="return(event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))"
                                placeholder="Ingresa capacidad">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>URL</label>
                            <input name="url" type="text" class="form-control"
                                    placeholder="Ingrese url">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="custom-switch mt-2">
                            <input type="checkbox" name="roomStatusCheckbox" id="edit-room-status-checkbox"
                                checked class="custom-switch-input">
                            <span class="custom-switch-indicator"></span>
                            <span id="txt-edit-description-room" class="custom-switch-description">Activo</span>
                        </label>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-close" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary btn-save">
                        Guardar
                        <i class="fa-solid fa-spinner fa-spin loadSpinner ms-1"></i>
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>


@endsection

