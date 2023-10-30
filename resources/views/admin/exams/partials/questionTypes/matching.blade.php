@php
    if (isset($question) && $question->evaluations_count != 0) {
        $isInvalid = true;
    }
@endphp

<hr>

<input type="hidden" id="typeQuestionValue" value="{{ $questionType_id }}">

<div class="form-row statement-points-group">

    <div class="form-group col-9">
        <label>Enunciado *</label>
        <input type="text" name="statement" class="form-control statement
        @if(isset($isInvalid)) not-user-allowed @endif" placeholder="Ingresa el enunciado"
            value="@if(isset($question)){{ $question->statement }}@endif" @if(isset($isInvalid)) readonly='true' @endif>
    </div>

    <div class="form-group col-2">
        <label>Puntos *</label>
        <input type="number" name="points" class="form-control points
        @if(isset($isInvalid)) not-user-allowed @endif" value="@if(isset($question)){{ $question->points }}@endif"
            @if(isset($isInvalid)) readonly='true' @endif>
    </div>

</div>

<hr>

<div class="mb-3">
    <h5 class="subtitle-header-show mb-3">
        Alternativas:
    </h5>
</div>

<table class="table table-hover">

    <thead>
        <tr>
            <th class="text-bold">Descripción</th>
            <th></th>
            <th class="text-bold"> Respuesta(s) Correcta(s) </th>
            <th class="text-bold text-center stretch-width"></th>
        </tr>
    </thead>
    <tbody id="alternatives-table">

        @if(isset($question))

        @foreach ($question->alternatives as $i => $alternative)

        <tr class="alternative-row" data-index="{{ $i }}">

            <input type="hidden" value="{{ $alternative->id }}" name="stored-alternatives[]">

            <td
                class="input-matching-column input-matching-column-width @if($alternative->file != null) with-image @endif">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text text-bold alternative-number">
                            {{ $i+1 }}
                        </div>
                    </div>
                    <input type="text" name="alternative[]" class="form-control alternative no-label-error
                    @if(isset($isInvalid)) not-user-allowed @endif" placeholder="Ingresa la alternativa"
                        value="{{ $alternative->description }}" @if(isset($isInvalid)) readonly='true' @endif>

                    <span class="position-relative image-icon-alternative">
                        <label for="alternative-image-{{ $i }}"
                            class="margin-0 @if(isset($isInvalid)) not-user-allowed @endif">
                            <i class="fa-solid fa-image fa-xl"></i>
                            <span class="inner-icon-context">
                                @if ($alternative->file != null)
                                <i class="fa-solid fa-arrows-rotate"></i>
                                @else
                                <i class="fa-solid fa-plus fa-xs"></i>
                                @endif
                            </span>
                        </label>
                        <input type="file" name="image-{{ $i }}" id="alternative-image-{{ $i }}"
                            class="input-alternative-image" data-value="" @if(isset($isInvalid)) readonly='true' @endif>
                    </span>
                </div>


                <div class="img-alternative-holder position-relative @if($alternative->file != null) show @endif">

                    @if ($alternative->file != null)

                    <span data-stored="true" data-url="{{ route('admin.exams.alternatives.deleteFile', $alternative) }}"
                        class="delete-image-alternative @if(isset($isInvalid)) not-user-allowed @endif">
                        <i class="fa-regular fa-circle-xmark fa-lg"></i>
                    </span>

                    <img src="{{ verifyImage($alternative->file) }}" class="img-fluid alternative_img">

                    @endif

                </div>


            </td>

            <td class="text-center relation-icon-column">
                <span class="matching-relation-column">
                </span>
            </td>

            <td class="input-matching-column-width">
                <input type="text" name="droppable-option[]" class="form-control droppable no-label-error
                @if(isset($isInvalid)) not-user-allowed @endif" placeholder="Ingresa la respuesta"
                    value="{{ $alternative->droppableOption->description }}" @if(isset($isInvalid)) readonly='true'
                    @endif>
            </td>

            <td class="text-center btn-action-container">
                <span data-stored="true" data-url="{{ route('admin.exams.alternatives.destroy', $alternative) }}"
                    class="delete-btn @if($i == 0 || isset($isInvalid)) disabled @else delete-alternative-btn @endif">
                    <i class="fa-solid fa-trash-can"></i>
                </span>
            </td>
        </tr>

        @endforeach

        @else

        <tr class="alternative-row" data-index="0">

            <td class="input-matching-column input-matching-column-width">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text text-bold alternative-number">
                            1
                        </div>
                    </div>
                    <input type="text" name="alternative[]" class="form-control alternative no-label-error"
                        placeholder="Ingresa la alternativa">

                    <span class="position-relative image-icon-alternative">
                        <label for="alternative-image-0" class="margin-0">
                            <i class="fa-solid fa-image fa-xl"></i>
                            <span class="inner-icon-context">
                                <i class="fa-solid fa-plus fa-xs"></i>
                            </span>
                        </label>
                        <input type="file" name="image-0" id="alternative-image-0" class="input-alternative-image"
                            data-value="">
                    </span>
                </div>



                <div class="img-alternative-holder position-relative">

                </div>



            </td>

            <td class="text-center relation-icon-column">
                <span class="matching-relation-column">
                </span>
            </td>

            <td class="input-matching-column-width">
                <input type="text" name="droppable-option[]" class="form-control droppable no-label-error"
                    placeholder="Ingresa la respuesta">
            </td>

            <td class="text-center btn-action-container">
                <span class="delete-btn disabled">
                    <i class="fa-solid fa-trash-can"></i>
                </span>
            </td>
        </tr>

        @endif



    </tbody>

</table>

<a href="javascript:void(0);"
    class="@if(!isset($isInvalid)) add_alternative_button @endif add_custom_button mt-3 @if(isset($isInvalid)) not-user-allowed @endif">
    <i class="fa-solid fa-plus fa-2xs"></i> &nbsp; Añadir alternativa
</a>

<div class="form-group mt-3 ms-2">
    <label class="custom-switch mt-2">
        <input type="checkbox" name="active" id="question-status-checkbox"
        @if(!isset($question)) checked @endif 
        @if(isset($question) && $question->active == 'S') checked @endif
            class="custom-switch-input">
        <span class="custom-switch-indicator"></span>
        <span id="txt-status-question" class="custom-switch-description">
            @if(isset($question))
            @if($question->active == 'S')
            Activo
            @else
            Inactivo
            @endif
            @else
            Activo
            @endif
        </span>
    </label>
</div>

<hr>

<div class="total-width text-right">
    <button type="submit" 
        class="btn btn-primary btn-save">
        Guardar
        <i class="fa-solid fa-spinner fa-spin loadSpinner ms-1"></i>
    </button>
</div>