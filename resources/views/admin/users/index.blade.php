@extends('admin.common.layouts.masterpage')

@section('content')

<div class="row content">


    <div class="main-container-page">
        <div class="card page-title-container">
            <div class="card-header">
                <div class="total-width-container">
                    <h4>USUARIOS</h4>
                </div>
            </div>
        </div>

        <div class="card-body card z-index-2 principal-container">

            <div class="mb-4">
                <button class="btn btn-primary" id="btn-register-user-modal" data-url='{{route('admin.users.registerGetCompanies')}}'>
                    <i class="fa-solid fa-user-plus"></i> &nbsp; Registrar
                </button>
            </div>

            <table id="users-table" class="table table-hover" data-url="{{route('admin.users.index')}}">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>DNI</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Empresa</th>
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

<div class="modal fade" id="RegisterUserModal" tabindex="-1" aria-labelledby="RegisterUserModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="RegisterUserModalLabel">
                    <div class="section-title mt-0">
                        <i class="fa-solid fa-user-plus"></i> &nbsp;
                        Registrar Usuario
                    </div>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{route('admin.user.store')}}" id="registerUserForm" method="POST" data-validate="{{route('admin.users.validateDni')}}">
                @csrf

                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputCompanyName">DNI *</label>
                            <div class="input-group">
                                <input type="text" name="dni" class="form-control dni"
                                        placeholder="Ingrese dni">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fa-solid fa-id-card"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="inputCompanyName">Nombre *</label>
                            <input type="text" name="name" class="form-control name"
                                placeholder="Ingrese nombre del usuario">
                        </div>

                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputPaterna">Apellido paterno *</label>
                            <input type="text" name="paternal" class="form-control"
                                placeholder="Ingrese el apellido paterno">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="inputName">Apellido materno *</label>
                            <input type="text" name="maternal" class="form-control" 
                                placeholder='Ingrese el apellido materno'>
                        </div>

                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="inputEmail">Email *</label>
                            <div class="input-group">
                                <input name="email" type="email" class="form-control"
                                     placeholder="Ingrese el correo del usuario">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fa-solid fa-envelope"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="inputPassword">Contraseña *</label>
                            <div class="input-group">
                                <input name="password" type="password" class="form-control"
                                     placeholder="Ingrese la contraseña del usuario">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fa-solid fa-lock"></i>
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
                            <label for="inputPhone">Rol *</label>
                            <div class="input-group">
                                <select name="role" class="form-control select2" id="registerRoleSelect">
                                    <option></option>
                                    <option value="instructor">Instructor</option>
                                    <option value="supervisor">Supervisor</option>
                                    <option value="participants">Participante</option>
                                    <option value="security_manager">Ingeniero de Seguridad</option>
                                    <option value="security_manager_admin">Gerente de Seguridad</option>
                                    <option value="technical_support">Soporte Técnico</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>CIP (opcional)</label>
                            <input type="text" name="cip" class="form-control" 
                            placeholder="Ingrese código CIP">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Empresa *</label>
                            <div class="input-group">
                                <select name="company" class="form-control select2" id="registerCompanySelect">
                            
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>Cargo (opcional)</label>
                            <input type="text" name="position" class="form-control" 
                            placeholder="Ingrese Cargo">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="custom-switch mt-2">
                            <input type="checkbox" name="userStatusCheckbox" id="register-user-status-checkbox"
                                checked class="custom-switch-input">
                            <span class="custom-switch-indicator"></span>
                            <span id="txt-register-description-user" class="custom-switch-description">Activo</span>
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


<div class="modal fade" id="EditUserModal" tabindex="-1" aria-labelledby="EditUserModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="EditUserModalLabel">
                    <div class="section-title mt-0">
                        <i class="fa-solid fa-user-pen"></i>&nbsp;
                        Editar Usuario
                    </div>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="" id="editUserForm" method="POST" data-validate='{{route('admin.user.editValidateDni')}}'>
                @csrf

                <input type="hidden" name='id'>

                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputDni">DNI</label>
                            <div class="input-group">
                                <input type="text" name="dni" class="form-control dni"
                                        placeholder="Ingrese dni">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fa-solid fa-id-card"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="inputCompanyName">Nombre </label>
                            <input type="text" name="name" class="form-control name"
                                placeholder="Ingrese nombre del usuario">
                        </div>

                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputPaterna">Apellido paterno</label>
                            <input type="text" name="paternal" class="form-control"
                                placeholder="Ingrese el apellido paterno">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="inputName">Apellido materno </label>
                            <input type="text" name="maternal" class="form-control" 
                                placeholder='Ingrese el apellido materno'>
                        </div>

                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="inputEmail">Email </label>
                            <div class="input-group">
                                <input name="email" type="email" class="form-control"
                                     placeholder="Ingrese el correo del usuario">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fa-solid fa-envelope"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="inputPassword">Nueva contraseña (opcional)</label>
                            <div class="input-group">
                                <input name="password" type="password" class="form-control"
                                     placeholder="Ingrese una nueva contraseña">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fa-solid fa-lock"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputPhone">Teléfono </label>
                            <input type="text" name="phone" class="form-control" 
                            placeholder="Ingrese teléfono">
                        </div>
                        
                        <div class="form-group col-md-6">
                            <label for="inputPhone">Rol</label>
                            <div class="input-group">
                                <select name="role" class="form-control select2" id="editRoleSelect">
                                    <option></option>
                                    <option value="instructor">Instructor</option>
                                    <option value="supervisor">Supervisor</option>
                                    <option value="participants">Participante</option>
                                    <option value="security_manager">Ingeniero de Seguridad</option>
                                    <option value="security_manager_admin">Gerente de Seguridad</option>
                                    <option value="technical_support">Soporte Técnico</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>CIP</label>
                            <input type="text" name="cip" class="form-control" 
                            placeholder="Ingrese código CIP">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Empresa *</label>
                            <div class="input-group">
                                <select name="company" class="form-control select2" id="editCompanySelect">
                            
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>Cargo</label>
                            <input type="text" name="position" class="form-control" 
                            placeholder="Ingrese Cargo">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="custom-switch mt-2">
                            <input type="checkbox" name="userStatusCheckbox" id="edit-user-status-checkbox"
                                checked class="custom-switch-input">
                            <span class="custom-switch-indicator"></span>
                            <span id="txt-edit-description-user" class="custom-switch-description">Activo</span>
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

