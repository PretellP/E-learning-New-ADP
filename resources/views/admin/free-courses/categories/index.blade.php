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

            <h5 class="title-header-show">
                <i class="fa-solid fa-chevron-left fa-xs"></i>
                <a href="{{route('admin.freeCourses.index')}}"> 
                    Inicio
                </a>  
            </h5>

            <div id="categorybox-show" class="category-box show mt-4 mb-4">

                @include('admin.free-courses.partials.category-box')

            </div>

            <h5 class="title-header-show mb-4">
                Cursos de:
                <span id="description-span" class="to-capitalize">
                    {{mb_strtolower($category->description, 'UTF-8')}}
                </span>
            </h5>

            <div class="action-btn-dropdown-container vertical show mb-4">
                <button class="btn btn-primary" id="btn-register-freecourse-modal">
                    <i class="fa-solid fa-plus"></i> &nbsp; 
                    Registrar
                    <i class="fa-solid fa-spinner fa-spin loadSpinner ms-1"></i>
                </button>
            </div>

            <table id="freecourse-category-show-table" class="table table-hover" data-url="{{route('admin.freeCourses.categories.index', $category)}}">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Nombre</th>
                        <th>Subtítulo</th>
                        <th>Categoría</th>
                        <th>N° de secciones</th>
                        <th>N° de capítulos</th>
                        <th>Duración total</th>
                        <th>Estado</th>
                        <th class="text-center">Recomendado</th>
                    </tr>
                </thead>
            </table>
            
        </div>

    </div>

</div>

@endsection

@section('modals')

<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="editCategoryModalLabel">
                    <div class="section-title mt-0">
                        <i class="fa-solid fa-pen-to-square"></i> &nbsp;
                        Editar Categoría
                    </div>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="" id="editCategoryForm" enctype="multipart/form-data" method="POST" data-validate="">
                @csrf

                <input type="hidden" name="place" value="show">

                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>Nombre *</label>
                            <div class="input-group">
                                <input type="text" name="description" class="form-control name"
                                        placeholder="Ingrese nombre de la categoría">
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>Imagen de la categoría * </label>
                            <div>
                                <div id="image-preview" class="image-preview">
                                    <label for="image-upload" id="image-label">Actualizar Imagen</label>
                                    <input type="file" name="image" id="image-upload-category-edit" data-value="">
                                    <div class="img-holder">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="custom-switch mt-2">
                            <input type="checkbox" name="status" id="edit-category-status-checkbox"
                                checked class="custom-switch-input">
                            <span class="custom-switch-indicator"></span>
                            <span id="txt-edit-description-category" class="custom-switch-description">Activo</span>
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


{{--  FREE COURSE   --}}

<div class="modal fade" id="RegisterfreeCourseModal" tabindex="-1" aria-labelledby="RegisterfreeCourseModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="RegisterfreeCourseModalLabel">
                    <div class="section-title mt-0">
                        <i class="fa-solid fa-square-plus"></i> &nbsp;
                        Registrar Curso libre
                    </div>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{route('admin.freecourses.courses.store')}}" id="registerFreeCourseForm" enctype="multipart/form-data" method="POST" data-validate="">
                @csrf

                <input type="hidden" name="place" value="index">
                <input type="hidden" name="fixedCategory" value="{{$category->id}}">
                <input type="hidden" name="category_id" value="{{$category->id}}">
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
                        <div class="form-group col-12">
                            <label>Categoría *</label>
                            <div id="category-description-register-modal" class="input-disabled to-capitalize">
                                {{mb_strtolower($category->description, 'UTF-8')}}
                            </div>
                        </div>
                       
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>Imagen del curso * </label>
                            <div>
                                <div id="image-preview" class="image-preview">
                                    <label for="image-upload" id="image-label">Subir Imagen</label>
                                    <input type="file" name="image" id="image-course-register">
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

                    <div class="form-group">
   
                        <label class="custom-switch mt-2">
                            <input type="checkbox" name="flg_recom" id="register-course-recom-checkbox"
                                 class="custom-switch-input">
                            <span class="custom-switch-indicator"></span>
                            <span id="txt-register-description-course-recom" class="custom-switch-description"> Registrar como curso recomendado </span>
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
    
@endsection