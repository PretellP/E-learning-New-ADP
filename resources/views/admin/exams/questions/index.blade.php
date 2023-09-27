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

            <h5 class="title-header-show">
                <i class="fa-solid fa-chevron-left fa-xs"></i>
                <a href="{{route('admin.exams.index')}}">Inicio</a>
                / Examen:
                <span id="exam-description-text-principal" class="to-capitalize">
                    {{mb_strtolower($exam->title, 'UTF-8')}}
                </span>
            </h5>

            <div id="exam-box-container" class="info-element-box mt-4 mb-3">

                @include('admin.exams.partials.exam-box')

            </div>

            <hr>

            <div class="principal-splitted-container mt-1 mb-2">

                <div class="principal-inner-container total-width">

                    <div class="inner-title-container">
                        <div id="" class="btn-dropdown-container show">
                            <h5 class="title-header-show"> Creación de enunciados </h5>
                            <div class="btn-row-container">
                                <div>
                                    <span class="text-dropdown-cont">
                                        Ocultar
                                    </span>
                                    <i class="fa-solid fa-chevron-down ms-2"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="related-dropdown-container">

                        <form id="registerQuestionForm" action="{{ route('admin.exams.questions.store', $exam) }}" method="POST">
                            @csrf

                            <div class="form-row questionTypeSelect">
                                <div class="form-group col-12">
                                    <label>Selecciona un tipo de enunciado *</label>
                                    <div class="input-group">
                                        <select name="question_type_id" class="form-control select2"
                                            id="registerQuestionTypeSelect"
                                            data-url="{{ route('admin.exams.questions.getType') }}">
                                            <option></option>
                                            @foreach ($questionTypes as $questionType)
                                            <option value="{{ $questionType->id }}"> {{ $questionType->description }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>


                            <div id="question-type-container">

                            </div>

                        </form>

                    </div>

                </div>

            </div>

            <hr>


            <h5 class="title-header-show mb-4">
                Lista de enunciados:
            </h5>

            <table id="questions-table" class="table table-hover"
                data-url="{{ route('admin.exams.showQuestions', $exam) }}">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Tipo de enunciado</th>
                        <th>Enunciado</th>
                        <th>Puntos</th>
                        <th>Fecha de creación</th>
                        <th>Fecha de actualización</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>

    </div>

</div>

@endsection

@section('modals')

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
                <input type="hidden" name="place" value="show">

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