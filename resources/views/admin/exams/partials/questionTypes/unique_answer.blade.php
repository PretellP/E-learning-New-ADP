<hr>

<input type="hidden" id="typeQuestionValue" value="{{ $questionType_id }}">

<div class="form-row statement-points-group">

    <div class="form-group col-10">
        <label>Enunciado *</label>
        <input type="text" name="statement" class="form-control statement" placeholder="Ingresa el enunciado">
    </div>

    <div class="form-group col-2">
        <label>Puntos *</label>
        <input type="number" name="points" class="form-control points">
    </div>

</div>

<hr>

<div class="flex-between mb-3">
    <h5 class="subtitle-header-show">
        Alternativas:
    </h5>

     <a href="javascript:void(0);" class="add_alternative_button">
        <i class="fa-solid fa-square-plus"></i> &nbsp; Añadir alternativa
     </a>
</div>

<table class="table table-hover table-sm">

    <thead>
        <tr>
            <th class="text-bold">Descripción</th>
            <th class="text-bold text-center stretch-width"> Alternativa correcta </th>
            <th class="text-bold text-center stretch-width"> Acción </th>
        </tr>
    </thead>
   <tbody id="alternatives-table">
        <tr class="alternative-row">
            <td>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text text-bold alternative-number">
                            1
                        </div>
                    </div>
                    <input type="text" name="alternative[]" class="form-control alternative no-label-error"
                        placeholder="Ingresa la alternativa">
                </div>
            </td>
            <td class="text-center flex-center">
                <label class="is_correct_button position-relative">
                    <input type="radio" name="is_correct" value="0" class="selectgroup-input" checked="checked">
                    <span class="selectgroup-button selectgroup-button-icon is_correct_btn">
                        <i class="fa-solid fa-check"></i>
                    </span>
                </label>
            </td>
            <td class="text-center btn-action-container">
                <span class="delete-btn disabled">
                    <i class="fa-solid fa-trash-can"></i> 
                </span>
            </td>
        </tr>
   </tbody>

</table>


<hr>

<div class="total-width text-right">
    <button type="submit" class="btn btn-primary btn-save">
        Guardar
        <i class="fa-solid fa-spinner fa-spin loadSpinner ms-1"></i>
    </button>
</div>