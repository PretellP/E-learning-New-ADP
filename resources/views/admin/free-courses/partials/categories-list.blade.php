@foreach ($categories as $category)
<div class="category-box">
    <div class="img-cat-container">
        <img class="cat-img" src="{{asset('storage/'.$category->url_img)}}">
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
                data-send="{{route('admin.freecourses.getDataCategory', $category)}}"
                data-url="{{route('admin.freecourses.categoryUpdate', $category)}}">
                <i class="fa-solid fa-pen-to-square"></i>
            </span>
            @if($category->courses->isEmpty())
            <span class="delete-btn deleteCategory-btn"
                data-url="{{route('admin.freecourses.deleteCategory', $category)}}">
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