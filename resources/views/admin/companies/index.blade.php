@extends('admin.common.layouts.masterpage')

@section('content')

<div class="row content">


    <div class="main-container-page">
        <div class="card page-title-container">
            <div class="card-header">
                <div class="total-width-container">
                    <h4>EMPRESAS</h4>
                </div>
            </div>
        </div>

        <div class="card-body card z-index-2 principal-container">

            <div class="mb-4">
                <button class="btn btn-primary" data-toggle="modal" data-target="#RegisterCompanyModal">
                    <i class="fa-solid fa-square-plus"></i> &nbsp; Registrar
                </button>
            </div>

            <table id="companies-table" class="table table-hover" data-url="{{route('admin.companies.index')}}">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Nombre</th>
                        <th>Abreviatura</th>
                        <th>RUC</th>
                        <th>Dirección</th>
                        <th>Teléfono</th>
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

<div class="modal fade" id="RegisterCompanyModal" tabindex="-1" aria-labelledby="RegisterCompanyModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="RegisterCompanyModalLabel">
                    <div class="section-title mt-0">
                        <i class="fa-solid fa-square-plus"></i> &nbsp;
                        Registrar Empresa
                    </div>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{route('admin.companies.store')}}" id="registerCompanyForm" method="POST">
                @csrf

                <input type="hidden" name='user_id'>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="inputCompanyName">Nombre *</label>
                            <div class="input-group">
                                <input type="text" name="name" class="form-control name"
                                    placeholder="Ingresa nombre de la empresa">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fa-solid fa-building"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputPassword">Abreviatura (opcional)</label>
                            <div class="input-group">
                                <input type="text" name="abreviation" class="form-control"
                                    placeholder="Ingresa abreviatura">
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="inputName">Ruc *</label>
                            <div class="input-group">
                                <input type="text" name="ruc" id="inputRucStore" class="form-control" 
                                placeholder='Ingrese RUC'>
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fa-solid fa-id-card"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="inputEmail">Dirección *</label>
                            <div class="input-group">
                                <input name="address" type="text" class="form-control"
                                     placeholder="Ingrese dirección">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fa-solid fa-map-location-dot"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputPhone">Teléfono (opcional)</label>
                            <input type="text" id="inputPhone" name="phone" class="form-control" 
                            placeholder="Ingrese teléfono">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputPhone">Nombre de referencia (opcional)</label>
                            <input type="text" name="referName" class="form-control" placeholder="Ingrese nombre de referencia">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Teléfono de referencia (opcional)</label>
                            <input type="text" name="referPhone" class="form-control" 
                            placeholder="Ingrese teléfono de referencia">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Correo de referencia (opcional)</label>
                            <input type="email" name="referEmail" class="form-control" placeholder="Ingrese correo de referencia">
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="custom-switch mt-2">
                            <input type="checkbox" name="companyStatusCheckbox" id="register-company-status-checkbox"
                                checked class="custom-switch-input">
                            <span class="custom-switch-indicator"></span>
                            <span id="txt-register-description-company" class="custom-switch-description">Activo</span>
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


<div class="modal fade" id="EditCompanyModal" tabindex="-1" aria-labelledby="EditCompanyModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="EditCompanyModalLabel">
                    <div class="section-title mt-0">
                        <i class="fa-solid fa-pen-to-square"></i> &nbsp;
                        Editar Empresa
                    </div>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="" id="EditCompanyForm" method="POST" data-validate='{{route('admin.companies.validateRuc')}}'>
                @csrf

                <input type="hidden" name='id'>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="inputCompanyName">Nombre *</label>
                            <div class="input-group">
                                <input type="text" name="name" class="form-control name"
                                    placeholder="Ingresa nombre de la empresa">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fa-solid fa-building"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputPassword">Abreviatura (opcional)</label>
                            <div class="input-group">
                                <input type="text" name="abreviation" class="form-control"
                                    placeholder="Ingresa abreviatura">
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="inputName">Ruc *</label>
                            <div class="input-group">
                                <input type="text" name="ruc" id="inputRucStore" class="form-control" 
                                placeholder='Ingrese RUC'>
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fa-solid fa-id-card"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="inputEmail">Dirección *</label>
                            <div class="input-group">
                                <input name="address" type="text" class="form-control"
                                     placeholder="Ingrese dirección">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fa-solid fa-map-location-dot"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputPhone">Teléfono (opcional)</label>
                            <input type="text" id="inputPhone" name="phone" class="form-control" 
                            placeholder="Ingrese teléfono">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputPhone">Nombre de referencia (opcional)</label>
                            <input type="text" name="referName" class="form-control" placeholder="Ingrese nombre de referencia">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Teléfono de referencia (opcional)</label>
                            <input type="text" name="referPhone" class="form-control" 
                            placeholder="Ingrese teléfono de referencia">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Correo de referencia (opcional)</label>
                            <input type="email" name="referEmail" class="form-control" placeholder="Ingrese correo de referencia">
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="custom-switch mt-2">
                            <input type="checkbox" name="companyStatusCheckbox" id="edit-company-status-checkbox"
                                checked class="custom-switch-input">
                            <span class="custom-switch-indicator"></span>
                            <span id="txt-edit-description-company" class="custom-switch-description">Activo</span>
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

