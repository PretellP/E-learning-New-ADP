
<div class="group-title mb-3">

    {{$group_position}}. {{$current_group->first()->group->name}}

</div>

@if (isset($group_options))
<div class="group-options-container">
    @foreach ($group_options as $option)
    <div class='group-option'>
        {{$option}}
    </div>
    @endforeach
</div>
@endif

<form id="survey-form" action="{{route('aula.surveys.update', [$user_survey, $group_id])}}" method='POST'>
    @method('PATCH')
    @csrf

    <div class="questions-container">
        @foreach ($current_group as $statement)

        <div class="question-box select-multiple">

            <div class="question-description">
                {{$statement->description}}
            </div>

            <div class="question-options-group">

                @if ($statement->type === 'select_multi')
                    @foreach (getOptionsFromStatementAsc($statement) as $option)
                    <div class="question-option">
                        <input class="input-radio-survey" type="radio" id="{{$option->id}}" {{getChekedInput($statement, $option)}} name="option-{{$statement->id}}" value='{{$option->description}}'>
                        <label for="{{$option->id}}">
                            <span class="circle-label-option">
                            </span>
                        </label>
                        <span>
                            {{ $option->description }}
                        </span>
                    </div>
                    @endforeach
                @elseif ($statement->type === 'commentary')
                    <div class="question-option commentary">
                        <input type="text" class="input-commentary-survey form-control" name="option-{{$statement->id}}" value="{{ $statement->pivot->answer ?? '' }}">
                    </div>
                @endif
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
