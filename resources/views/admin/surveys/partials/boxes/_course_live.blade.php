
<hr>

<div class="mb-3">
    <h5 class="subtitle-header-show">
        Opciones:
    </h5>

</div>

<table class="table table-sm">

    <thead>
        <tr>
            <th class="text-bold">Descripción</th>
        </tr>
    </thead>
   <tbody id="option-table">

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
                    <input type="text" readonly="readonly" name="option[]"
                        class="not-user-allowed form-control alternative no-label-error"
                        placeholder="Ingresa la opción" value="{{ $option->description }}">
                </div>
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
                    <input type="text" readonly="readonly" name="option[]"
                        class="not-user-allowed form-control alternative no-label-error"
                        placeholder="Ingresa la opción" value="SÍ">
                </div>
            </td>
        </tr>

        <tr class="alternative-row" data-index="1">
            <td>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text text-bold alternative-number">
                            2
                        </div>
                    </div>
                    <input type="text" readonly="readonly" name="option[]" 
                        class="not-user-allowed form-control alternative no-label-error"
                        placeholder="Ingresa la opción" value="NO">
                </div>
            </td>
        </tr>

        @endif

   </tbody>

</table>

<hr>
