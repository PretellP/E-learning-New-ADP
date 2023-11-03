<div class="img-element-container">
    <img src="{{verifyImage($survey->file)}}">
</div>
<div class="info-element-general-container">
    <div class="info-name-element-container">
        <div class="name-info">
            {{$survey->name}}
        </div>
        <div class="category-info">
            <div class="cat-text little-text">Destinado para:</div>
            <span class="to-capitalize text-bold text-primary">
                {{mb_strtolower(config('parameters.survey_destined_to')[$survey->destined_to], 'UTF-8')}}
            </span>
        </div>
    </div>

    <div class="extra-info-container">

        <div>
            <div>
                <span class="little-text little-text-width">N° de grupos: </span>
                <span class="text-bold">
                    {{$survey->survey_groups_count}} 
                </span>
            </div>
        </div>

        <div>
            <div>
                <span class="little-text little-text-width">N° de preguntas: </span>
                <span class="text-bold">
                    {{$survey->statements_count}} 
                </span>
            </div>
        </div>

        <div class="pt-1">
            <div class="status-cont text-no-wrap d-flex justify-content-between"> 
                <span class="text-info-stat little-text"> Estado: &nbsp;</span>
                <span class="status {{getStatusClass($survey->active)}}">
                     {{getStatusText($survey->active)}} 
                </span>
            </div>
        </div>

    </div>

    <div class="element-status-cont">

        <div class="pt-1">
            <div class="d-flex justify-content-between align-items-center gap-1">
                <span class="little-text text-bold">
                    Fecha de creación:
                </span>
                <span>
                    {{ $survey->created_at }}
                </span>
            </div>
            <div class="d-flex justify-content-between align-items-center gap-1 mt-1">
                <span class="little-text text-bold">
                    Fecha de actualización:
                </span>
                <span>
                    {{ $survey->updated_at }}
                </span>
            </div>
        </div>
        
    </div>

    <div class="action-box info-element-box">
        <div class="btn-action-container">
            <span id="survey-edit-btn" class="editSurvey edit-btn"
                data-url="{{ route('admin.surveys.all.update', $survey) }}"
                data-send="{{ route('admin.surveys.all.edit', $survey) }}">
                <i class="fa-solid fa-pen-to-square"></i>
            </span>
            @if($survey->survey_groups_count == 0)
                <span class="delete-btn deleteSurvey" data-type="show"
                        data-url="{{ route('admin.surveys.all.destroy', $survey) }}" data-type="soft">
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