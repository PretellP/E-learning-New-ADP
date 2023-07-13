<form id="matchingQuiz" class="steps" method="POST" action="{{route('aula.course.quiz.update', [$certification, $exam, ($num_question+1), $key+1, $evaluation->id])}}">

    @method('PATCH')

    @csrf

    <fieldset>

        <div class="info-question">
            <h2 class="fs-title"> {{$question->statement}}  </h2> 
        </div>

        <div class="alert-container">
            <p>
                <i class="fa-solid fa-circle-exclamation fa-bounce fa-lg"></i> &nbsp;
                Debes Relacionar al menos una opción para continuar
            </p>
        </div>

        <div class="box-quiz-head matching-container">

            <input type="hidden" name="question" value="{{$question->id}}">

            <div class="options-container">
                <section id="draggable-section">

                    @foreach($alts_ids as $alt_id)

                        @php
                            $alternative = getAlternativeFromId($alt_id);
                        @endphp
    
                        <div class="draggable" draggable="true" id='{{$alt_id}}'>
                            <img draggable="false" src="{{asset($alternative->url_img)}}" alt="">
                            <span>
                                {{$alternative->description}}
                            </span>
                        </div>
    
                    @endforeach
    
                </section>
    
                <section id="droppable-section">

                    @php
                        $selected_options_array = explode(",", $evaluation->selected_alternatives);
                    @endphp
    
                    @foreach($options_ids as $option_id)

                    @php
                        $trigger_selected = false;
                        $droppable_option = getDroppableOptionFromId($option_id);
                        foreach($selected_options_array as $selected_option)
                        {
                            $opt_and_alt_array = explode(":", $selected_option);
                            if($option_id == $opt_and_alt_array[0])
                            {
                                $trigger_selected = true;
                                break;
                            } 
                        } 
                    @endphp

                    <div class="droppable-option">
                        <div class="droppable" draggable="false" id="option-{{$option_id}}">
                            <img draggable="false" src="" alt="">
                            <span></span>
                            <input type="hidden" class="droppable_input" required name="option-{{$option_id}}" 
                            value="@if($trigger_selected){{$opt_and_alt_array[1]}}@endif">
                        </div>
                        <span>
                            {{$droppable_option->description}}
                        </span>
                    </div>  
    
                    @endforeach
    
                </section>
            </div>
            
        </div>
        
        <div class="box-quiz-body">

           

            <div class="btn-prev">
                @if (($num_question+1) != '1')
                    <a href="{{route('aula.course.quiz.show', [$certification, ($num_question)])}}">
                            <i class="fa-solid fa-angles-left"></i>
                    </a>  
                @endif
            </div>
            
            <div class="btn-save">
                @if (($num_question + 1) != count($evaluations))
                    <button type="submit" name="next" class="next action-button save-matching" value="Guardar">
                        <i class="fa-solid fa-angles-right"></i>
                    </button>
                @endif
                @if (($num_question + 1) == count($evaluations))
                    <button type="submit" id="submit" class="hs-button primary large action-button next save-matching" value="Finalizar">
                        <i class="fa-solid fa-check"></i>
                    </button>
                @endif
            </div>
        
        </div>

    </fieldset>

</form>



