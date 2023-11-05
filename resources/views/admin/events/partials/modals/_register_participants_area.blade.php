<div class="modal fade" id="RegisterParticipantsAreaModal" tabindex="-1"
    aria-labelledby="RegisterParticipantsMassiveModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="RegisterParticipantsAreaModalLabel">
                    <div class="section-title mt-0">
                        <i class="fa-solid fa-file-import"></i> &nbsp;
                        Área y observaciones masivo de participantes
                    </div>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>


            <a href="{{ route('admin.events.certifications.download.participants_area.template') }}"
                class="btn btn-success col-6 mt-2 mx-auto">
                <i class="fa-solid fa-download me-1"></i>
                Descargar plantilla
            </a>

            <form action="{{ route('admin.events.certifications.store.area_massive', $event) }}" id="registerParticipantsAreaForm" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="modal-body">

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="inputEmail">Subir archivo *</label>
                            <div class="input-group">
                                <input name="file" type="file" class="form-control" placeholder="Seleccione un archivo">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fa-solid fa-file-import"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
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