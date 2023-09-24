@extends('admin.common.layouts.masterpage')

@section('content')

<div class="row content">


    <div class="main-container-page">
        <div class="card page-title-container">
            <div class="card-header">
                <div class="total-width-container">
                    <h4>CURSOS</h4>
                </div>
            </div>
        </div>

        <div class="card-body card z-index-2 principal-container">

            <div class="mb-4">
                <button class="btn btn-primary" data-toggle="modal" data-target="#RegisterCourseModal">
                    <i class="fa-solid fa-square-plus"></i>  &nbsp; Registrar
                </button>
            </div>

            <table id="courses-table" class="table table-hover" data-url="{{route('admin.courses.index')}}">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Nombre</th>
                        <th>Subtítulo</th>
                        <th>Fecha</th>
                        <th>Hora Inicio</th>
                        <th>Hora Fin</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>
            
        </div>

    </div>

</div>

@endsection

@section('modals')

<div class="modal fade" id="RegisterCourseModal" tabindex="-1" aria-labelledby="RegisterCourseModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="RegisterUserModalLabel">
                    <div class="section-title mt-0">
                        <i class="fa-solid fa-square-plus"></i> &nbsp;
                        Registrar Curso
                    </div>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{route('admin.courses.store')}}" id="registerCourseForm" enctype="multipart/form-data" method="POST" data-validate="">
                @csrf

                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>Nombre *</label>
                            <div class="input-group">
                                <input type="text" name="description" class="form-control dni"
                                        placeholder="Ingrese nombre del curso">
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>Subtítulo (opcional)</label>
                            <input type="text" name="subtitle" class="form-control"
                                placeholder="Ingrese subtítulo">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Fecha *</label>
                            <input type="text" name="date" class="form-control datepicker">
                        </div>

                        <div class="form-group col-md-6">
                            <label>Horas *</label>
                            <input type="number" name="hours" step="0.1" min="0.1" class="form-control">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Hora de inicio *</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                      <i class="fas fa-clock"></i>
                                    </div>
                                  </div>
                                <input name="time_start" type="text" class="form-control timepicker">
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label>Hora de fin *</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                      <i class="fas fa-clock"></i>
                                    </div>
                                  </div>
                                <input name="time_end" type="text" class="form-control timepicker">
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>Imagen del curso (opcional) </label>
                            <div>
                                <div id="image-preview" class="image-preview">
                                    <label for="image-upload" id="image-label">Subir Imagen</label>
                                    <input type="file" name="image" id="course-image-register">
                                    <div class="img-holder">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="custom-switch mt-2">
                            <input type="checkbox" name="active" id="register-course-status-checkbox"
                                checked class="custom-switch-input">
                            <span class="custom-switch-indicator"></span>
                            <span id="txt-register-description-course" class="custom-switch-description">Activo</span>
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


<div class="modal fade" id="editCourseModal" tabindex="-1" aria-labelledby="editCourseModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="editCourseModalLabel">
                    <div class="section-title mt-0">
                        <i class="fa-solid fa-pen-to-square"></i>&nbsp;
                        Editar Curso
                    </div>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="" id="editCourseForm" enctype="multipart/form-data" method="POST"'>
                @csrf

                <input type="hidden" name='id'>

                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>Nombre</label>
                            <div class="input-group">
                                <input type="text" name="description" class="form-control dni"
                                        placeholder="Ingrese nombre del curso">
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>Subtítulo</label>
                            <input type="text" name="subtitle" class="form-control"
                                placeholder="Ingrese subtítulo">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Fecha</label>
                            <input type="text" name="date" class="form-control datepicker">
                        </div>

                        <div class="form-group col-md-6">
                            <label>Horas</label>
                            <input type="number" name="hours" step="0.1" min="0.1" class="form-control">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Hora de inicio</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                      <i class="fas fa-clock"></i>
                                    </div>
                                  </div>
                                <input name="time_start" type="text" class="form-control timepicker">
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label>Hora de fin</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                      <i class="fas fa-clock"></i>
                                    </div>
                                  </div>
                                <input name="time_end" type="text" class="form-control timepicker">
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>Imagen del curso</label>
                            <div>
                                <div id="image-preview" class="image-preview">
                                    <label for="image-upload" id="image-label">Subir Imagen</label>
                                    <input type="file" name="image" id="input-course-image-update" data-value="">
                                    <div class="img-holder">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="custom-switch mt-2">
                            <input type="checkbox" name="active" id="edit-course-status-checkbox"
                                checked class="custom-switch-input">
                            <span class="custom-switch-indicator"></span>
                            <span id="txt-edit-description-course" class="custom-switch-description">Activo</span>
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

@endsection

