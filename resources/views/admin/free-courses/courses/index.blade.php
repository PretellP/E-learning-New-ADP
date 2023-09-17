@extends('admin.common.layouts.masterpage')

@section('content')

<div class="row content">

    <div class="main-container-page">
        <div class="card page-title-container">
            <div class="card-header">
                <div class="total-width-container">
                    <h4>CURSOS LIBRES</h4>
                </div>
            </div>
        </div>

        <div class="card-body card z-index-2 principal-container">

            <h5 class="title-course-show">
                <i class="fa-solid fa-chevron-left fa-xs"></i>
                <a href="{{route('admin.freeCourses.index')}}">Inicio</a> 
                / Categoría: 
                <a href="{{route('admin.freeCourses.categories.index', ['category' => $course->courseCategory])}}" class="to-capitalize">
                    {{mb_strtolower($course->courseCategory->description, 'UTF-8')}}</a>
                / Curso: 
                <span id="course-description-text-principal" class="to-capitalize">
                    {{mb_strtolower($course->description, 'UTF-8')}}
                </span>
            </h5>

            <div id="course-box-container" class="course-box mt-4 mb-4">

                @include('admin.free-courses.partials.course-box')
              
            </div>


            <div class="principal-splitted-container">
                <div class="principal-inner-container left">

                    <div class="inner-title-container">
                        <h5 class="title-course-show"> Secciones </h5>
                        <div class="btn-row-container">
                            <div id="btn-drowdown-sections-list" class="btn-dropdown-container show">
                                <span class="text-dropdown-cont">
                                    Ocultar
                                </span>
                                <i class="fa-solid fa-chevron-down ms-2"></i>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 action-btn-dropdown-container show top-container-inner-box">
                        <button class="btn btn-primary" id="btn-register-section-modal"  data-toggle="modal" data-target="#registerSectionModal">
                            <i class="fa-solid fa-plus"></i> &nbsp; Añadir sección
                        </button>
                    </div>

                    <div id="sections-list-container" class="sections-list-container related-dropdown-container mt-0 show">
                        @include('admin.free-courses.partials.sections-list')
                    </div>

                </div>

                <div class="principal-inner-container right">

                    <div class="inner-title-container">
                        <h5 class="title-course-show"> 
                            Capítulos 
                            <span id="top-chapter-table-title-info">
                                
                            </span>
                        </h5>
                        <div class="btn-row-container">
                            <div id="btn-drowdown-chapters-list" class="btn-dropdown-container vertical show">
                                <span class="text-dropdown-cont">
                                    Ocultar
                                </span>
                                <i class="fa-solid fa-chevron-down ms-2"></i>
                               
                            </div>
                        </div>
                    </div>

                    <div id="chapters-list-container" class="related-dropdown-container table-container show">
                        
                        @include('admin.free-courses.partials.chapter-list-empty')
       
                    </div>
                </div>
            </div>
           
            
        </div>

    </div>

</div>

@endsection

@section('modals')

{{--  FREE COURSE   --}}

<div class="modal fade" id="editFreeCourseModal" tabindex="-1" aria-labelledby="editFreeCourseModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="editFreeCourseModalLabel">
                    <div class="section-title mt-0">
                        <i class="fa-solid fa-pen-to-square"></i> &nbsp;
                        Editar Curso libre
                    </div>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{route('admin.freeCourses.updateFreecourse', $course)}}" id="editFreeCourseForm" enctype="multipart/form-data" method="POST" data-validate="">
                @csrf

                <input type="hidden" name="place" value="index">
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>Nombre *</label>
                            <div class="input-group">
                                <input type="text" name="name" class="form-control description"
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
                        <div class="form-group col-12">
                            <label>Categoría *</label>
                            <div class="input-disabled to-capitalize">
                                {{mb_strtolower($course->courseCategory->description, 'UTF-8')}}
                            </div>
                        </div>
                       
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>Imagen del curso * </label>
                            <div>
                                <div id="image-preview" class="image-preview">
                                    <label for="image-upload" id="image-label">Subir Imagen</label>
                                    <input type="file" name="courseImageEdit" id="image-upload-freecourse-edit">
                                    <div class="img-holder">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="custom-switch mt-2">
                            <input type="checkbox" name="courseStatusCheckbox" id="edit-course-status-checkbox"
                                checked class="custom-switch-input">
                            <span class="custom-switch-indicator"></span>
                            <span id="txt-edit-description-course" class="custom-switch-description">Activo</span>
                        </label>
                    </div>

                    <div class="form-group">
   
                        <label class="custom-switch mt-2">
                            <input type="checkbox" name="courseRecomCheckbox" id="edit-course-recom-checkbox"
                                 class="custom-switch-input">
                            <span class="custom-switch-indicator"></span>
                            <span id="txt-edit-description-course-recom" class="custom-switch-description"> 
                                Registrar como curso recomendado 
                            </span>
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


{{-- SECTIONS --}}

<div class="modal fade" id="registerSectionModal" tabindex="-1" aria-labelledby="registerSectionModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="registerSectionModalLabel">
                    <div class="section-title mt-0">
                        <i class="fa-solid fa-square-plus"></i> &nbsp;
                        Añadir sección
                    </div>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{route('admin.freeCourses.sections.store', $course)}}" id="registerSectionForm"  method="POST">
                @csrf

                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>Título *</label>
                            <div class="input-group">
                                <input type="text" name="title" class="form-control title"
                                        placeholder="Ingrese el título de la sección">
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

<div class="modal fade" id="editSectionModal" tabindex="-1" aria-labelledby="editSectionModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="editSectionModalLabel">
                    <div class="section-title mt-0">
                        <i class="fa-solid fa-pen-to-square"></i> &nbsp;
                        Editar sección
                    </div>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="" id="editSectionForm"  method="POST">
                @csrf

                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>Título *</label>
                            <div class="input-group">
                                <input type="text" name="title" class="form-control title"
                                        placeholder="Ingrese el título de la sección">
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="selectOrder">Orden *</label>
                            <div class="input-group">
                                <select name="order" class="form-control select2" id="editOrderSelect">
                                </select>
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
    
@endsection