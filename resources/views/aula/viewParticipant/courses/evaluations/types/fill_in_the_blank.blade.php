<form class="steps" method="POST" action="{{route('aula.course.quiz.update', [$certification, $exam, ($num_question+1), $key+1, $evaluation->id])}}" id="">

    @method('PATCH')

    @csrf

    <fieldset>

        <div class="info-question">
            <p> Escribe la respuesta correcta </p>
        </div>

        <div class="alert-container">
            <p>
                <i class="fa-solid fa-circle-exclamation fa-bounce fa-lg"></i> &nbsp;
                Debes seleccionar una opción para continuar
            </p>
        </div>

        <div class="box-quiz-head">
            <h2 class="fs-title title-fill"> {{$question->statement}}  </h2> 

            <input type="hidden" name="question" value="{{$question->id}}">
        </div>
        
        <div class="box-quiz-body">

            <div class="btn-prev">
                @if (($num_question+1) != '1')
                    <a href="{{route('aula.course.quiz.show', [$certification, ($num_question)])}}">
                            <i class="fa-solid fa-angles-left"></i>
                    </a>  
                @endif
            </div>

            <div class="box-answers">
                @foreach($question->alternatives()->get() as $i => $alternative)

                <div class="hs_firstname field hs-form-field answers-colors box-fill">

                    <input id="{{$alternative->id}}" class="input-txt" name="alternative[]" autocomplete="off" placeholder="Escribe tu respuesta"
                            required type="text" value="{{old('alternative[]', (explode(',', $evaluation->selected_alternatives))[$i])}}">

                </div>

                @endforeach

            </div>
            
            <div class="btn-save save-fill">
                @if (($num_question + 1) != count($evaluations))
                    <button type="submit" name="next" class="next action-button txt-submit" value="Guardar">
                        <i class="fa-solid fa-angles-right"></i>
                    </button>
                @endif
                @if (($num_question + 1) == count($evaluations))
                    <button type="submit" id="submit" class="hs-button primary large action-button next txt-submit" value="Finalizar">
                        <i class="fa-solid fa-check"></i>
                    </button>
                @endif
            </div>
        
        </div>

    </fieldset>

</form>
