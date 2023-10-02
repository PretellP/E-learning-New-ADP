
<div class="info-element-general-container">

    <div class="info-name-element-container">
        <div class="name-info to-capitalize">
            <span class="little-text">
                Título: 
            </span>
            <div class="text-bold">
                {{ mb_strtolower($exam->title) }}
            </div>
        </div>
        <div>
            <span class="little-text">
                Curso:
            </span>
           <div class="content-text">
                {{ $exam->course->description }}
           </div>
        </div>
    </div>

    <div class="extra-info-container">
        <div class="subtitle-cont">
            <div class="subt-text little-text">Empresa Titular: </div>
            <div>
                {{ $exam->ownerCompany->name }}
            </div>
        </div>
        <div class="counts-cont text-no-wrap">
            <div class="sections-cont">
                <span class="little-text little-text-width">N° de enunciados: </span>
                <span class="text-bold">
                   {{ $exam->questions_count }}
                </span>
            </div>
            <div class="chapters-cont">
                <span class="little-text little-text-width">Puntaje total: </span>
                <span class="text-bold">
                    {{ $exam->questions_sum_points }}
                </span>
            </div>
        </div>
       
    </div>

    <div class="element-status-cont">

        <div class="duration-cont">
            <span class="little-text">
                Duración: 
            </span>
            <div class="text-no-wrap">
                {{ $exam->exam_time }} min.
            </div>
        </div>

        <div class="status-icon-container">
            <div class="status-cont text-no-wrap"> 
                <span class="text-info-stat little-text"> Estado: &nbsp;</span>
                <span class="status {{getStatusClass($exam->active)}}">
                     {{getStatusText($exam->active)}} 
                </span>
            </div>
        </div>
        
    </div>

    <div class="action-box info-element-box">

        <div class="btn-action-container">
            <span id="exam-edit-btn" class="edit-btn" 
                data-url="{{ route('admin.exams.update', $exam) }}"
                data-send="{{ route('admin.exams.edit', $exam) }}">
                <i class="fa-solid fa-pen-to-square"></i>
            </span>
            @if(
                $exam->questions_count == 0 &&
                $exam->events_count == 0
            )
                <span class="delete-btn delete-exam-btn"
                        data-url="{{ route('admin.exams.destroy', $exam) }}"> 
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
