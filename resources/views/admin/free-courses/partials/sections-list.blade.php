@foreach ($course->courseSections as $section)

<div class="course-section-box {{setSectionActive($section, $sectionActive)}}"
            data-active="{{setSectionActive($section, $sectionActive)}}" 
            data-table="{{route('admin.freeCourses.chapters.getDataTable', $section)}}"
            id="section-box-{{$section->id}}"
            data-id="{{$section->id}}">
    <div class="order-info">
        <span class="text-bold">  
            {{$section->section_order}}
        </span>
    </div>
    <div class="title-container">
        <div class="little-text">Título: </div>
        <span class="text-bold">
            {{$section->title}}
        </span>
    </div>
    <div class="chapters-count">
        <div class="little-text"> Capítulos: </div>
        <span class="text-bold">
            {{$section->section_chapters_count}}
        </span>
    </div>
    <div class="order-select-container">
        <span class="little-text">Orden: </span>
        <div class="input-group">
            <select name="order"
                data-url="{{route('admin.freecourses.sections.updateOrder', $section)}}"
                class="form-control select2 order-section-select">
                @foreach ($course->courseSections as $order)
                    <option {{getSelectedOption($section, $order->section_order)}} value="{{$order->section_order}}"> 
                        {{$order->section_order}} 
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="action-box clean-list">
        <div class="btn-action-container">
            <span class="section-edit-btn edit-btn" data-send="{{route('admin.freeCourses.sections.edit', $section)}}"
                data-url="{{route('admin.freeCourses.sections.update', $section)}}">
                <i class="fa-solid fa-pen-to-square"></i>
            </span>
            @if($section->section_chapters_count == 0)
                <span class="delete-btn delete-section-btn"
                        data-url="{{route('admin.freeCourses.sections.delete', $section)}}"> 
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

@endforeach