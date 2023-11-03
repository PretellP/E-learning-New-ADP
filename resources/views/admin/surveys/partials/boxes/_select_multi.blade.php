<hr>

<div class="mb-3">

    <h5 class="subtitle-header-show mb-3">
        Opciones:
    </h5>

</div>

<table class="table table-hover table-sm">

    <thead>
        <tr>
            <th class="text-bold">Descripción</th>
            <th class="text-bold text-center stretch-width"></th>
        </tr>
    </thead>

    <tbody id="options-table">

        @if(isset($statement))

        @foreach ($statement->options as $i => $option)

        <tr class="alternative-row" data-index="{{ $i }}">

            <input type="hidden" value="{{ $option->id }}" name="stored-options[]">

            <td>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text text-bold alternative-number">
                            {{ $i+1 }}
                        </div>
                    </div>
                    <input type="text" name="option[]" class="form-control alternative no-label-error"
                        placeholder="Ingresa la opción" value="{{ $option->description }}">
                </div>
            </td>
            <td class="text-center btn-action-container">
                <span data-stored="true"
                    data-url="{{ route('admin.surveys.all.groups.statement.options.destroy', $option) }}"
                    class="delete-btn @if($i==0) disabled @else delete-option-btn @endif">
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
                    <input type="text" name="option[]" class="form-control alternative no-label-error"
                        placeholder="Ingresa la opción">
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

<a href="javascript:void(0);" class="add_option_button add_custom_button mt-3">
    <i class="fa-solid fa-plus fa-2xs"></i> &nbsp; Añadir opción
</a>

<hr>
