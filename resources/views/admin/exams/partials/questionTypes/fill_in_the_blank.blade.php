<hr>

<input type="hidden" id="typeQuestionValue" value="{{ $questionType_id }}">

<div class="form-row statement-points-group">

    <div class="form-group col-9">
        <label>Enunciado *</label>
        <input id="statement-fill-blank" type="text" name="statement" class="form-control statement"
            placeholder="Ingresa el enunciado" value="@if(isset($question)){{ $question->statement }}@endif">
    </div>

    <div class="form-group col-2">
        <label>Puntos *</label>
        <input type="number" name="points" class="form-control points"
            value="@if(isset($question)){{ $question->points }}@endif">
    </div>

</div>

<a href="javascript:void(0);" class="add_custom_button add-blank-space-btn">
    <i class="fa-solid fa-plus fa-2xs"></i> &nbsp; Añadir espacio en blanco
</a>

<span class="tooltip">
    &nbsp; <i class="fa-regular fa-circle-question fa-lg"></i>
    <span class="tooltiptext">
        Puede añadir espacios colocando el cursor en la posición deseada <br>
        y luego haciendo click en "Añadir espacio en blanco".
    </span>
</span>

<hr>

<div class="mb-3">
    <h5 class="subtitle-header-show mb-3">
        Respuestas:
    </h5>
</div>

<table class="table table-hover table-sm">

    <thead>
        <tr>
            <th class="text-bold">Descripción</th>
            <th class="text-bold text-center stretch-width"></th>
        </tr>
    </thead>
    <tbody id="alternatives-table">

        @if(isset($question))

        @foreach ($question->alternatives as $i => $alternative)

        <tr class="alternative-row" data-index="{{ $i }}">

            <input type="hidden" value="{{ $alternative->id }}" name="stored-alternatives[]">

            <td>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text text-bold alternative-number">
                            {{ $i+1 }}
                        </div>
                    </div>
                    <input type="text" name="alternative[]" class="form-control alternative no-label-error"
                        placeholder="Ingresa la(s) respuesta(s)" value="{{ $alternative->description }}">
                </div>
            </td>
            <td class="text-center btn-action-container">
                <span data-stored="true"
                    data-url="{{ route('admin.exams.alternatives.destroy', $alternative) }}"
                    class="delete-btn @if($i == 0) disabled @else delete-alternative-btn @endif">
                    <i class="fa-solid fa-trash-can"></i>
                </span>
            </td>
        </tr>

        @endforeach

        @else

        <tr class="alternative-row" data-index="0">
            <td>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text text-bold alternative-number">
                            1
                        </div>
                    </div>
                    <input type="text" name="alternative[]" class="form-control alternative no-label-error"
                        placeholder="Ingresa la(s) respuesta(s)">
                </div>
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

<a href="javascript:void(0);" class="add_alternative_button add_custom_button mt-3">
    <i class="fa-solid fa-plus fa-2xs"></i> &nbsp; Añadir respuesta
</a>


<span class="tooltip">
    &nbsp; <i class="fa-regular fa-circle-question fa-lg"></i>
    <span class="tooltiptext">
        Puede separar múltiples respuestas correctas con una coma (,) <br>
        Ejemplo: Examen, Evaluación, Prueba <br>
        Eso evaluará cualquiera de las respuestas como correcta.
    </span>
</span>


<hr>

<div class="total-width text-right">
    <button type="submit" class="btn btn-primary btn-save">
        Guardar
        <i class="fa-solid fa-spinner fa-spin loadSpinner ms-1"></i>
    </button>
</div>