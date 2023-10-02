<div class="modal fade" id="registerEventModal" tabindex="-1" aria-labelledby="registerEventModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="registerEventModalLabel">
                    <div class="section-title mt-0">
                        <i class="fa-solid fa-square-plus"></i> &nbsp;
                        Registrar Evento
                    </div>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{ route('admin.events.store') }}" id="registerEventForm" method="POST">
                @csrf

                <div class="modal-body">

                    <div class="form-row">
                        <div class="form-group col-12">
                            <label>Descripciòn *</label>
                            <input type="text" name="description" class="form-control description"
                                placeholder="Ingresa la descripción del evento">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-6">
                            <label>Tipo *</label>
                            <div class="input-group">
                                <select name="type" class="form-control select2" id="registerTypeSelect">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-6">
                            <label>Fecha *</label>
                            <input type="text" name="date" class="form-control datepicker">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-12">
                            <label>Instructor *</label>
                            <div class="input-group">
                                <select name="user_id" class="form-control select2" id="registerInstructorSelect">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-12">
                            <label>Responsable *</label>
                            <div class="input-group">
                                <select name="responsable_id" class="form-control select2"
                                    id="registerResponsableSelect">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-6">
                            <label>Sala *</label>
                            <div class="input-group">
                                <select name="room_id" class="form-control select2" id="registerRoomSelect">
                                    <option></option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group col-6">
                            <label>Empresa Titular (opcional)</label>
                            <div class="input-group">
                                <select name="owner_companies_id" class="form-control select2"
                                    id="registerOwnerCompanySelect">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-12">
                            <label>Examen *</label>
                            <div class="input-group">
                                <select name="exam_id" class="form-control select2" id="registerExamSelect">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-12">
                            <label>Examen de prueba (opcional)</label>
                            <div class="input-group">
                                <select name="test_exam_id" class="form-control select2" id="registerTestExamSelect">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-12">
                            <label>E-Learning (opcional)</label>
                            <div class="input-group">
                                <select name="elearning_id" class="form-control select2" id="registerElearningSelect">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">

                        <div class="form-group col-3">
                            <label class="custom-switch mt-2">
                                <input type="checkbox" name="active" id="register-status-checkbox" checked
                                    class="custom-switch-input">
                                <span class="custom-switch-indicator"></span>
                                <span id="txt-register-status" class="custom-switch-description">Activo</span>
                            </label>

                        </div>

                        <div class="form-group col-6">
                            <label class="custom-switch mt-2">
                                <input type="checkbox" name="flg_test_exam" id="register-flg-test-checkbox" checked
                                    class="custom-switch-input">
                                <span class="custom-switch-indicator"></span>
                                <span id="txt-register-flg-test" class="custom-switch-description">Examen de prueba
                                    activo</span>
                            </label>
                        </div>

                        <div class="form-group col-3">
                            <label class="custom-switch mt-2">
                                <input type="checkbox" name="flg_asist" id="register-flg-assist-checkbox" checked
                                    class="custom-switch-input">
                                <span class="custom-switch-indicator"></span>
                                <span id="txt-register-flg-assist" class="custom-switch-description">Asistencias</span>
                            </label>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-close" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary btn-save btn-event-register" value="index">
                        Guardar
                        <i class="fa-solid fa-spinner fa-spin loadSpinner ms-1"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>