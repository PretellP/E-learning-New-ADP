<div class="modal fade" id="registerBannerModal" tabindex="-1" aria-labelledby="registerBannerModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="registerBannerModalTitle">
                    <div class="title-header-show mt-0">
                        <i class="fa-solid fa-plus"></i>&nbsp;
                        <span>
                            Añadir banner
                        </span>
                    </div>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"> &times; </span>
                </button>
            </div>

            <form action="{{ route('admin.announcements.banner.store') }}" id="registerBannerForm" method="POST" enctype="multipart/form-data">

                <div class="modal-body">

                    <div class="form-row">
                        <div class="form-group col-12">
                            <label>Agregar URL (opcional)</label>
                            <input type="text" name="content" class="form-control content"
                                placeholder="Ingresa una URL">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-3">
                            <div class="custom-checkbox custom-control">
                                <input type="checkbox" id="checkbox-blank-indicator" name="blank_indicator"
                                    class="custom-control-input" value="1">
                                <label for="checkbox-blank-indicator" class="custom-control-label">
                                    &nbsp;
                                    Abrir en una pestaña nueva
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>Banner * </label>
                            <div>
                                <div id="image-preview" class="image-preview banner-container-image">
                                    <label for="image-upload" id="image-label">Subir Imagen</label>
                                    <input type="file" name="image" id="input-banner-image-register">
                                    <div class="img-holder">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <label class="custom-switch">
                                <input type="checkbox" id="register-banner-status-checkbox" name="status" 
                                    class="custom-switch-input status_banner_checkbox" checked>
                                <span class="custom-switch-indicator"></span>
                                <span id="txt-register-status-banner" class="custom-switch-description">Activo</span>
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