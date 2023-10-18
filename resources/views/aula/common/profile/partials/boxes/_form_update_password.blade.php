
<div class="profile-row mt-4 flex-column">

    <div class="d-flex justify-content-between">
        <div class="d-flex align-items-center">
            <i class="fa-solid fa-lock me-2"></i> &nbsp;
            <b>
                Actualizar contraseña
            </b>
        </div>

        <div class="btn-unlock-edit p-2">
            <i class="fa-solid fa-pen-to-square fa-lg text-warning"></i>
        </div>
    </div>

    <hr>

    <div class="error-credentials-message text-center hide">
        <i class="fa-solid fa-triangle-exclamation"></i> &nbsp;
        La contraseña ingresada no coincide con la actual. Inténtelo nuevamente.
    </div>

    <div class="form-row">

        <div class="form-group col-12 col-md-6">
            <label for="">Contraseña actual: </label>
            <div class="input-group">
                <input type="password" name="old_password" class="form-control" disabled>
                <div class="input-group-prepend change-view-password">
                    <div class="input-group-text">
                        <i class="fa-solid fa-eye"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group col-12 col-md-6">
            <label for="">Nueva contraseña: </label>
            <div class="input-group">
                <input type="password" name="new_password" class="form-control" disabled>
                <div class="input-group-prepend change-view-password">
                    <div class="input-group-text">
                        <i class="fa-solid fa-eye"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-primary btn-save" disabled>
            <span class="mx-2">
                Guardar
            </span>
            <i class="fa-solid fa-spinner fa-spin loadSpinner"></i>
        </button>
    </div>

</div>

