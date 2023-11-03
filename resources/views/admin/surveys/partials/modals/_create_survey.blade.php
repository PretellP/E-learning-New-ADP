<div class="modal fade" id="RegisterSurveyModal" tabindex="-1" aria-labelledby="RegisterSurveyModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="RegisterSurveyModalLabel">
                    <div class="section-title mt-0">
                        <i class="fa-solid fa-square-plus"></i> &nbsp;
                        Registrar encuesta
                    </div>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{ route('admin.surveys.all.store') }}" id="registerSurveyForm" method="POST"'>
                @csrf

                <div class="modal-body">
                    
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="inputRoomName">Nombre *</label>
                            <input type="text" name="name" class="form-control name"
                                placeholder="Ingresa nombre de la encuesta">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-12">
                            <label>Destinado para *</label>
                            <div class="input-group">
                                <select name="destined_to" class="form-control select2" id="registerSurveySelect">
                                    <option></option>
                                    @foreach (config('parameters.survey_destined_to') as $key => $destined_to)
                                        <option value="{{$key}}"> {{ $destined_to }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>Imagen de la encuesta (opcional) </label>
                            <div>
                                <div id="image-preview" class="image-preview card-container-image">
                                    <label for="image-upload" id="image-label">Subir Imagen</label>
                                    <input type="file" name="image" id="input-image-survey-register">
                                    <div class="img-holder">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="custom-switch mt-2">
                            <input type="checkbox" name="active" id="register-survey-status-checkbox"
                                checked class="custom-switch-input">
                            <span class="custom-switch-indicator"></span>
                            <span id="txt-register-description-survey" class="custom-switch-description">Activo</span>
                        </label>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-close" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary btn-save" value="index">
                        Guardar
                        <i class="fa-solid fa-spinner fa-spin loadSpinner ms-1"></i>
                    </button>
                    <button type="submit" class="btn btn-primary btn-save" value="show">
                        Guardar y ver
                        &nbsp;
                        <i class="fa-solid fa-caret-right"></i>
                        <i class="fa-solid fa-spinner fa-spin loadSpinner ms-1"></i>
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
