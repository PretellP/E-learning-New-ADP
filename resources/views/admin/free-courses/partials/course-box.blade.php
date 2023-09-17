<div class="img-course-container">
    <img src="{{asset('storage/'.$course->url_img)}}">
</div>
<div class="info-course-general-container">
    <div class="info-name-course-container">
        <div class="name-info">
            {{$course->description}}
        </div>
        <div class="category-info">
            <div class="cat-text little-text">Categoría</div>
            <span class="to-capitalize text-bold text-primary">
                {{mb_strtolower($course->courseCategory->description, 'UTF-8')}}
            </span>
        </div>
    </div>
    <div class="extra-info-container">
        <div class="subtitle-cont">
            <div class="subt-text little-text">Subtítulo: </div>
            <span>
                {{$course->subtitle}} 
            </span>
        </div>
        <div class="counts-cont">
            <div class="sections-cont">
                <span class="little-text">Secciones: </span>
                <span class="text-bold">
                    {{$course->courseSections->count()}} 
                </span>
            </div>
            <div class="chapters-cont">
                <span class="little-text">Capítulos: </span>
                <span class="text-bold">
                    {{getFreeCourseTotalChapters($course)}} 
                </span>
            </div>
        </div>
       
    </div>
    <div class="course-status-cont">
        <div class="duration-cont">
            <span class="little-text">
                Duración: 
            </span>
            <div class="text-no-wrap">
                {{getFreeCourseTime($course)}} 
            </div>
        </div>
        <div class="status-icon-container">
            <div class="status-cont text-no-wrap"> 
                <span class="text-info-stat little-text"> Estado: &nbsp;</span>
                <span class="status {{getStatusClass($course->active)}}">
                     {{getStatusText($course->active)}} 
                </span>
            </div>
            <div class="stat-recom-cont text-no-wrap">
                <span class="text-info-stat little-text"> Recomendado: &nbsp; </span>
                <span class="icon-recom-cont text-center">
                    {!!getStatusRecomended($course->flg_recom)!!}
                </span>
            </div>
        </div>
        
    </div>
    <div class="action-box course-box">
        <div class="btn-action-container">
            <span id="freecourse-edit-btn" class="edit-btn" data-send="{{route('admin.freecourse.getDatacourse', $course)}}">
                <i class="fa-solid fa-pen-to-square"></i>
            </span>
            @if($course->courseSections->isEmpty())
                <span class="delete-btn delete-course-btn"
                        data-url="{{route('admin.freecourses.deleteCourse', $course)}}" data-type="soft"> 
                    <i class="fa-solid fa-trash-can"></i> 
                </span>
            @else
                <span class="delete-btn disabled"> 
                    <i class="fa-solid fa-trash-can"></i> 
                </span>
            @endif
            
        </div>
    </div>
    
</div>