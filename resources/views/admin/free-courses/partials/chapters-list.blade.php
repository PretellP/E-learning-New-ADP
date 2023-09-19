<div class="action-btn-dropdown-container top-container-inner-box">
    <button class="btn btn-primary" id="btn-register-chapter-modal" data-url="{{route('admin.freeCourses.chapters.store', $section)}}"  
        data-toggle="modal" data-target="#registerChapterModal">
        <i class="fa-solid fa-plus"></i> &nbsp; Añadir capítulo
    </button>
</div>

<table id="freeCourses-chapters-table" class="table table-hover">
    <thead>
        <tr>
            <th>Título</th>
            <th>Descripción</th>
            <th>Duración</th>
            <th>Orden</th>
            <th>Previsualizar</th>
            <th class="action-with">Acciones</th>
        </tr>
    </thead>
</table>

