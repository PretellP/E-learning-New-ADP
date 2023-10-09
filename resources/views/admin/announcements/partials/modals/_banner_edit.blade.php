<div class="modal fade" id="editBannerModal" tabindex="-1" aria-labelledby="editBannerModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="edtBannerModalTitle">
                    <div class="title-header-show mt-0">
                        <i class="fa-solid fa-pen-to-square"></i>&nbsp;
                        <span>
                            Editar banner
                        </span>
                    </div>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"> &times; </span>
                </button>
            </div>

            <form action="" id="editBannerForm" method="POST" enctype="multipart/form-data">

                <div class="banner-url-content-container d-none">

                </div>

                <div class="modal-body">

                    <div class="form-row">
                        <div class="form-group col-12">
                            <label>Editar URL (opcional)</label>
                            <input type="text" name="content" class="form-control content"
                                placeholder="Ingresa una URL">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-3">
                            <div class="custom-checkbox custom-control">
                                <input type="checkbox" id="checkbox-blank-indicator-edit" name="blank_indicator"
                                    class="custom-control-input" value="1">
                                <label for="checkbox-blank-indicator-edit" class="custom-control-label">
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
                                    <input type="file" name="image" id="input-banner-image-edit">
                                    <div class="img-holder">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="form-row">
                        <div class="form-group col-3">
                            <label for="inputOrder">Orden *</label>
                            <div class="input-group">
                                <select name="publishing_order" class="form-control select2" id="editOrderSelect">

                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <label class="custom-switch">
                            <input type="checkbox" id="edit-banner-status-checkbox" name="status"
                                class="custom-switch-input status_banner_checkbox">
                            <span class="custom-switch-indicator"></span>
                            <span id="txt-edit-status-banner" class="custom-switch-description">Activo</span>
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