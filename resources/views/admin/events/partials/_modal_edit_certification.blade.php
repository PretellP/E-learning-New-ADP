<div class="modal fade" id="editCertificationModal" tabindex="-1" aria-labelledby="editCertificationModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="editCertificationModalLabel">
                    <div class="section-title mt-0">
                        <i class="fa-solid fa-pen-to-square"></i> &nbsp;
                        Editar Certificado
                    </div>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="" id="editCertificationForm" method="POST">
                @csrf

                <div class="modal-body">

                    <div class="form-row">
                        <div class="form-group col-12">
                            <label>Participante</label>
                            <div class="input-disabled" id="participant-name">
                                Nombre del participante
                            </div>
                        </div>
                    </div>

                    {{-- <div class="form-row">
                        <div class="form-group col-12">
                            <label>Unidades Mineras *</label>
                            <div class="input-group">
                                <select name="mining_unit_id[]" class="form-control select2" id="editCertMiningUnitSelect" multiple>
                               
                                </select>
                            </div>
                        </div>
                    </div> --}}

                    <div class="form-row">
                        <div class="form-group col-12">
                            <label>Empresa (opcional) </label>
                            <div class="input-group">
                                <select name="company_id" class="form-control select2" id="editCertCompanySelect">
                                  
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-12">
                            <label>Área (opcional)</label>
                            <input type="text" name="area" class="form-control description">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-12">
                            <label>Observación (opcional)</label>
                            <input type="text" name="observation" class="form-control description">
                        </div>
                    </div>
                    

                    <div class="form-group">
                        <label class="custom-switch mt-2">
                            <input type="checkbox" name="assist_user" id="edit-assist-checkbox"
                                class="custom-switch-input">
                            <span class="custom-switch-indicator"></span>
                            <span id="txt-edit-assist" class="custom-switch-description">Asistencia</span>
                        </label>

                    </div>


                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-close" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary btn-save btn-certification-edit">
                        Guardar
                        <i class="fa-solid fa-spinner fa-spin loadSpinner ms-1"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>