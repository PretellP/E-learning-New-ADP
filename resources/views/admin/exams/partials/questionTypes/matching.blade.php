<hr>

<input type="hidden" id="typeQuestionValue" value="{{ $questionType_id }}">

<div class="form-row statement-points-group">

    <div class="form-group col-9">
        <label>Enunciado *</label>
        <input type="text" name="statement" class="form-control statement" placeholder="Ingresa el enunciado">
    </div>

    <div class="form-group col-2">
        <label>Puntos *</label>
        <input type="number" name="points" class="form-control points">
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

        <tr class="alternative-row">

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
                        <input type="file" name="image-0" id="alternative-image-0" class="input-alternative-image" data-value="">
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

   </tbody>

</table>

<a href="javascript:void(0);" class="add_alternative_button add_custom_button mt-3">
    <i class="fa-solid fa-plus fa-2xs"></i> &nbsp; Añadir alternativa
 </a>

<hr>

<div class="total-width text-right">
    <button type="submit" class="btn btn-primary btn-save">
        Guardar
        <i class="fa-solid fa-spinner fa-spin loadSpinner ms-1"></i>
    </button>
</div>