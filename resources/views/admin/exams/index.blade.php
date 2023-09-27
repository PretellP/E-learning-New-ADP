@extends('admin.common.layouts.masterpage')

@section('content')

<div class="row content">


    <div class="main-container-page">
        <div class="card page-title-container">
            <div class="card-header">
                <div class="total-width-container">
                    <h4>EXÁMENES</h4>
                </div>
            </div>
        </div>

        <div class="card-body card z-index-2 principal-container">

            <div class="mb-4">
                <button class="btn btn-primary" data-toggle="modal" data-target="#RegisterExamModal">
                    <i class="fa-solid fa-square-plus"></i> &nbsp; Registrar
                </button>
            </div>

            <table id="exams-table" class="table table-hover" data-url="{{route('admin.exams.index')}}">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Título</th>
                        <th>Empresa Titular</th>
                        <th>Curso</th>
                        <th>Duración</th>
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

<div class="modal fade" id="RegisterExamModal" tabindex="-1" aria-labelledby="RegisterExamModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="RegisterCompanyModalLabel">
                    <div class="section-title mt-0">
                        <i class="fa-solid fa-square-plus"></i> &nbsp;
                        Registrar Examen
                    </div>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{route('admin.exams.store')}}" id="registerExamForm" method="POST">
                @csrf

                <div class="modal-body">

                    <div class="form-row">
                        <div class="form-group col-12">
                            <label>Título *</label>
                            <input type="text" name="title" class="form-control title"
                                placeholder="Ingresa el título del examen">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-12">
                            <label>Empresa Titular *</label>
                            <div class="input-group">
                                <select name="owner_company_id" class="form-control select2"
                                    id="registerOwnerCompanySelect">
                                    <option></option>
                                    @foreach ($ownerCompanies as $ownerCompany)
                                    <option value="{{$ownerCompany->id}}">{{$ownerCompany->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-12">
                            <label>Curso *</label>
                            <div class="input-group">
                                <select name="course_id" class="form-control select2" id="registerCourseSelect">
                                    <option></option>
                                    @foreach ($courses as $course)
                                    <option value="{{$course->id}}">{{$course->description}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>Duración (Minutos) *</label>
                            <input type="number" name="exam_time" class="form-control exam_time"
                                placeholder="Ingresa la duración del examen">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="custom-switch mt-2">
                            <input type="checkbox" name="active" id="register-exam-status-checkbox" checked
                                class="custom-switch-input">
                            <span class="custom-switch-indicator"></span>
                            <span id="txt-register-description-exam" class="custom-switch-description">Activo</span>
                        </label>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-close" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary btn-save btn-exam-register" value="index">
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

<div class="modal fade" id="editExamModal" tabindex="-1" aria-labelledby="editExamModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="editExamModalLabel">
                    <div class="section-title mt-0">
                        <i class="fa-solid fa-pen-to-square"></i> &nbsp;
                        Editar Examen
                    </div>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="" id="editExamForm" method="POST">
                @csrf
                <input type="hidden" name="place" value="index">

                <div class="modal-body">

                    <div class="form-row">
                        <div class="form-group col-12">
                            <label>Título *</label>
                            <input type="text" name="title" class="form-control title"
                                placeholder="Ingresa el título del examen">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-12">
                            <label>Empresa Titular *</label>
                            <div class="input-group">
                                <select name="owner_company_id" class="form-control select2"
                                    id="editOwnerCompanySelect">
                                  
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-12">
                            <label>Curso *</label>
                            <div class="input-group">
                                <select name="course_id" class="form-control select2" id="editCourseSelect">
                                   
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>Duración (Minutos) *</label>
                            <input type="number" name="exam_time" class="form-control exam_time"
                                placeholder="Ingresa la duración del examen">
                        </div>
                    </div>

                    <option></option>

                    <div class="form-group">
                        <label class="custom-switch mt-2">
                            <input type="checkbox" name="active" id="edit-exam-status-checkbox" checked
                                class="custom-switch-input">
                            <span class="custom-switch-indicator"></span>
                            <span id="txt-edit-description-exam" class="custom-switch-description">Activo</span>
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