<div class="action-btn-dropdown-container show top-container-inner-box">
    <button class="btn btn-primary" id="btn-register-category-modal" data-toggle="modal"
        data-target="#RegisterCategoryModal">
        <i class="fa-solid fa-plus"></i> &nbsp; Registrar
    </button>
</div>

@foreach ($categories as $category)

<div class="category-box">
    <div class="img-cat-container">
        <img class="cat-img" src="{{verifyImage($category->file)}}">
    </div>
    <div class="info-cat-container">
        <div class="cat-description">
            {{$category->description}}
        </div>
        <div class="cat-status-btn">
            <span class="status {{getStatusClass($category->status)}}"> {{getStatusText($category->status)}} </span>
        </div>
    </div>
    <div class="action-box">
        <div class="btn-action-container">
            <span class="edit-btn editCategory-btn"
                data-send="{{route('admin.freecourses.categories.edit', $category)}}"
                data-url="{{route('admin.freecourses.categories.update', $category)}}">
                <i class="fa-solid fa-pen-to-square"></i>
            </span>
            @if($category->courses_count == 0)
            <span class="delete-btn deleteCategory-btn"
                data-url="{{route('admin.freecourses.categories.delete', $category)}}">
                <i class="fa-solid fa-trash-can"></i>
            </span>
            @else
            <span class="delete-btn disabled">
                <i class="fa-solid fa-trash-can"></i>
            </span>
            @endif
        </div>

        <div class="btn-show">
            <a href="{{route('admin.freeCourses.categories.index', $category)}}">
                <span>Ingresar</span>
                <i class="fa-solid fa-circle-right"></i>
            </a>
        </div>

    </div>
</div>
@endforeach