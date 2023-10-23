
<div class="info-element-general-container">

    <div class="info-name-element-container">
        <div class="name-info">
            <span class="little-text">
                Nombre: 
            </span>
            <div class="text-bold">
                {{ $group->name }}
            </div>
        </div>
        <div>
            <span class="little-text">
                Encuesta:
            </span>
           <div class="content-text">
                {{ $group->survey->name }}
           </div>
        </div>
    </div>

    <div class="extra-info-container">
        <div class="subtitle-cont">
            <div class="subt-text little-text">Descripción: </div>
            <div>
                {{ $group->description }}
            </div>
        </div>
        <div class="text-no-wrap">
            <div class="d-flex justify-content-between align-items-center gap-1">
                <span class="little-text text-bold">
                    Fecha de creación:
                </span>
                <span>
                    {{ $group->created_at }}
                </span>
            </div>
            <div class="d-flex justify-content-between align-items-center gap-1 mt-1">
                <span class="little-text text-bold">
                    Fecha de actualización:
                </span>
                <span>
                    {{ $group->updated_at }}
                </span>
            </div>
        </div>
       
    </div>

    <div class="action-box info-element-box">

        <div class="btn-action-container">
            <span id="group-edit-btn" class="edit-btn editGroup" 
                data-url="{{ route('admin.surveys.groups.update', $group) }}"
                data-send="{{ route('admin.surveys.groups.edit', $group) }}">
                <i class="fa-solid fa-pen-to-square"></i>
            </span>
            @if(
                $group->statements_count == 0
            )
                <span class="delete-btn deleteGroup" data-type="show"
                        data-url="{{ route('admin.surveys.groups.destroy', $group) }}"> 
                    <i class="fa-solid fa-trash-can"></i> 
                </span>
            @else
                <span class="delete-btn disabled"> 
                    <i class="fa-solid fa-trash-can"></i> 
                </span>
            @endif
            
        </div>

    </div>
    
</div>
