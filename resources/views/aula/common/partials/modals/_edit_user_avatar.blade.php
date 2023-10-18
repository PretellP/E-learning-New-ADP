<div id="user_avatar_edit_modal" class="iziModal"
data-iziModal-title="Cambiar Avatar">
    
    <form id="edit-user-avatar-form" action="{{ route('aula.profile.updateUserAvatar', ["user" => Auth::user()]) }}" method="POST" enctype="multipart/form-data">

        <section>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label> Avatar * </label>
                    <div>
                        <div id="image-preview" class="image-preview">
                            <label for="image-upload" id="image-label">Subir Imagen</label>
                            <input type="file" name="image" id="input-user-avatar-edit" data-value="">
                            <div class="img-holder">

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <footer>
                <button data-iziModal-close>Cancelar</button>
                <button type="submit" class="submit btn-save">
                    Confirmar
                    <i class="fa-solid fa-spinner fa-spin loadSpinner"></i>
                </button>
            </footer>

        </section>

    </form>

</div>