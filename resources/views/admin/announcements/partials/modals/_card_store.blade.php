<div class="modal fade" id="registerCardModal" tabindex="-1" aria-labelledby="registerCardModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="registerCardModalTitle">
                    <div class="title-header-show mt-0">
                        <i class="fa-solid fa-plus"></i>&nbsp;
                        <span>
                            Añadir publicación
                        </span>
                    </div>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"> &times; </span>
                </button>
            </div>

            <form action="{{ route('admin.announcements.card.store') }}" id="registerCardForm" method="POST" enctype="multipart/form-data">

                <div class="modal-body">

                    <div class="form-row">
                        <div class="form-group col-12">
                            <label>Título *</label>
                            <input type="text" name="title" class="form-control title"
                                placeholder="Ingresa el título">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-12">
                            <label>Contenido *</label>
                            <textarea name="content" class="summernote-card-editor" id="card-content-register"></textarea>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-12">
                            <label>Imagen * </label>
                            <div class="d-flex justify-content-center">
                                <div class="col-6">
                                    <div id="image-preview" class="image-preview card-container-image">
                                        <label for="image-upload" id="image-label">Subir Imagen</label>
                                        <input type="file" name="image" id="input-card-image-register">
                                        <div class="img-holder">
    
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <label class="custom-switch">
                                <input type="checkbox" id="register-card-status-checkbox" name="status" 
                                    class="custom-switch-input status_card_checkbox" checked>
                                <span class="custom-switch-indicator"></span>
                                <span id="txt-register-status-card" class="custom-switch-description">
                                    Activar publicación
                                </span>
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