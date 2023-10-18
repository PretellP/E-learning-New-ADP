<div class="modal fade" id="RegisterUserModal" tabindex="-1" aria-labelledby="RegisterUserModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
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

            <form action="{{route('admin.user.store')}}" id="registerUserForm" method="POST"
                data-validate="{{route('admin.users.validateDni')}}" enctype="multipart/form-data">
                @csrf

                <div class="modal-body">

                    <div class="d-flex form-row modal-multiple-columns">

                        <div class="col-6">

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
                                    <input type="text" id="inputPhone" name="telephone" class="form-control"
                                        placeholder="Ingrese teléfono">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="inputPhone">Rol *</label>
                                    <div class="input-group">
                                        <select name="role" class="form-control select2" id="registerRoleSelect">
                                            <option></option>
                                            @foreach($roles as $key => $role)
                                            <option value="{{ $key }}"> {{ $role }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>


                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>CIP (opcional)</label>
                                    <input type="text" name="cip" class="form-control" placeholder="Ingrese código CIP">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Empresa *</label>
                                    <div class="input-group">
                                        <select name="company_id" class="form-control select2" id="registerCompanySelect">

                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-6">

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label> Unidades mineras *</label>
                                    <select id="registerMiningUnitsSelect" name="id_mining_units[]"
                                        class="form-control select2" multiple="multiple">
                                        <option></option>
                                        @foreach ($miningUnits as $miningUnit)
                                        <option value="{{$miningUnit->id}}"> {{strtoupper($miningUnit->description)}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Cargo (opcional)</label>
                                    <input type="text" name="position" class="form-control" placeholder="Ingrese Cargo">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Imagen (opcional) </label>
                                    <div class="square-img-input-container">
                                        <div id="image-preview" class="image-preview">
                                            <label for="image-upload" id="image-label">Subir Imagen</label>
                                            <input type="file" name="image" id="input-user-image-store" data-value="">
                                            <div class="img-holder img-cover">
        
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>


                    <div class="form-group">
                        <label class="custom-switch mt-2">
                            <input type="checkbox" name="active" id="register-user-status-checkbox" checked
                                class="custom-switch-input">
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