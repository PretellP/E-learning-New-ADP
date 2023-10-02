<div class="modal fade" id="editEventModal" tabindex="-1" aria-labelledby="editEventModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="editEventModalLabel">
                    <div class="section-title mt-0">
                        <i class="fa-solid fa-pen-to-square"></i> &nbsp;
                        Editar Evento
                    </div>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="" id="editEventForm" method="POST">
                @csrf

                <div class="modal-body">

                    <input type="hidden" name="place" value="{{$show ?? '' }}">

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
                                <select name="type" class="form-control select2" id="editTypeSelect">
                               
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-6">
                            <label>Fecha *</label>
                            <input type="text" name="date" id="dateinputEdit" class="form-control datepicker">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-12">
                            <label>Instructor *</label>
                            <div class="input-group">
                                <select name="user_id" class="form-control select2" id="editInstructorSelect">
                                  
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-12">
                            <label>Responsable *</label>
                            <div class="input-group">
                                <select name="responsable_id" class="form-control select2"
                                    id="editResponsableSelect">
                                 
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-6">
                            <label>Sala *</label>
                            <div class="input-group">
                                <select name="room_id" class="form-control select2" id="editRoomSelect">
                               
                                </select>
                            </div>
                        </div>

                        <div class="form-group col-6">
                            <label>Empresa Titular (opcional)</label>
                            <div class="input-group">
                                <select name="owner_companies_id" class="form-control select2"
                                    id="editOwnerCompanySelect">
                         
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-12">
                            <label>Examen *</label>
                            <div class="input-group">
                                <select name="exam_id" class="form-control select2" id="editExamSelect">
                              
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-12">
                            <label>Examen de prueba (opcional)</label>
                            <div class="input-group">
                                <select name="test_exam_id" class="form-control select2" id="editTestExamSelect">
                              
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-12">
                            <label>E-Learning (opcional)</label>
                            <div class="input-group">
                                <select name="elearning_id" class="form-control select2" id="editElearningSelect">
                              
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">

                        <div class="form-group col-3">
                            <label class="custom-switch mt-2">
                                <input type="checkbox" name="active" id="edit-status-checkbox" checked
                                    class="custom-switch-input">
                                <span class="custom-switch-indicator"></span>
                                <span id="txt-edit-status" class="custom-switch-description">Activo</span>
                            </label>

                        </div>

                        <div class="form-group col-6">
                            <label class="custom-switch mt-2">
                                <input type="checkbox" name="flg_test_exam" id="edit-flg-test-checkbox" checked
                                    class="custom-switch-input">
                                <span class="custom-switch-indicator"></span>
                                <span id="txt-edit-flg-test" class="custom-switch-description">Examen de prueba
                                    activo</span>
                            </label>
                        </div>

                        <div class="form-group col-3">
                            <label class="custom-switch mt-2">
                                <input type="checkbox" name="flg_asist" id="edit-flg-assist-checkbox" checked
                                    class="custom-switch-input">
                                <span class="custom-switch-indicator"></span>
                                <span id="txt-edit-flg-assist" class="custom-switch-description">Asistencias</span>
                            </label>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-close" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary btn-save btn-event-edit" value="{{ $show ?? '' }}">
                        Guardar
                        <i class="fa-solid fa-spinner fa-spin loadSpinner ms-1"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>