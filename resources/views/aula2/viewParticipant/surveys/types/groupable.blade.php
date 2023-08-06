
<div class="group-title">

    {{$group_position}}. {{$current_group->first()->group->name}}

</div>

<div class="group-options-container">
    @foreach ($group_options as $option)
        <div class='group-option'>
            {{$option}}
        </div>
    @endforeach
</div>

<form id="survey-form" action="{{route('aula.surveys.update', [$user_survey, $group_id])}}" method='POST'>
    @method('PATCH')
    @csrf

    <div class="questions-container">
        @foreach ($current_group as $statement)

        <div class="question-box">
            <div class="question-description">
                {{$statement->description}}
            </div>

            <div class="question-options-group">

                @foreach (getOptionsFromStatement($statement) as $option)
                <div class="question-option">
                    <input class="input-radio-survey" type="radio" id="{{$option->id}}" {{getChekedInput($statement, $option)}} name="option-{{$statement->id}}" value='{{$option->description}}'>
                    <label for="{{$option->id}}">
                        <span class="circle-label-option">
                        </span>
                    </label>
                </div>
                @endforeach
        
            </div>
        
        </div>
        
        @endforeach
    </div>

    <div class="btn-survey-container">

        @if ($previous_num_question != null)
        <a class="survey-previous-btn" href="{{route('aula.surveys.show', [$user_survey, 'num_question'=>$previous_num_question])}}">
            Atrás
        </a>
        @endif

        <button id="btn-submit-survey" type="submit" class="btn-survey-submit">
        @if (verifyLastSurveyGroup($answersByGroup, $group_position))
            Finalizar
        @else
            Guardar y Continuar
        @endif
        </button>
    
    </div>

</form>

<div class="survey-progress-bar-container">

    @for ($i = 0; $i<count($answersByGroup); $i++)
    
    <div class="survey-progress-bar @if($group_position>$i)active @endif">
    </div>

    @endfor
</div>
