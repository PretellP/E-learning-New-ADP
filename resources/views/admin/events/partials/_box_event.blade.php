<div class="info-element-general-container">

    <div class="info-name-element-container">
        <div class="name-info to-capitalize mb-1">
            <span class="little-text text-center">
                N° {{ $event->id }}
            </span>
            <div class="text-bold">
                {{ $event->description }}
            </div>
            <div class="little-text">
                {{ $event->subtitle ?? '-' }}
            </div>
        </div>

        <div class="pt-2">
            <div class="flex-between flex-vertical-center mb-1">
                <span class="little-text">
                    Tipo:
                </span>
                <span class="content-text">
                    {{ config('parameters.event_types')[verifyEventType($event->type)] }}
                </span>
            </div>
            <div class="flex-between flex-vertical-center ">
                <span class="little-text">
                    Fecha:
                </span>
                <div class="content-text">
                    {{ $event->date }}
                </div>
            </div>
        </div>

        <div class="pt-2">
            <span class="little-text text-center">
                Capacitador:
            </span>
            <div class="d-flex justify-content-between mt-1 align-items-center gap-1">
                <span class="content-text text-left">
                    {{ $event->user->full_name_complete }}
                </span>
                <span class="little-text text-no-wrap">
                    DNI: {{ $event->user->dni }}
                </span>
            </div>

            <span class="little-text text-center mt-1">
                Responsable:
            </span>
            <div class="d-flex justify-content-between mt-1 align-items-center gap-1">
                <span class="content-text text-left">
                    {{ $event->responsable->full_name_complete }}
                </span>
                <span class="little-text text-no-wrap">
                    DNI: {{ $event->responsable->dni }}
                </span>
            </div>
        </div>

    </div>

    <div class="extra-info-container">
        <div class="mb-1">
            <div class="subt-text little-text text-center">Sala: </div>
            <div class="d-flex justify-content-between gap-1">
                <span>
                    {{ $event->room->description }}
                </span>
                <span>
                    <span class="little-text">
                        Capacidad:
                    </span>
                    <span>
                        {{ $event->room->capacity }}
                    </span>
                </span>
            </div>
        </div>

        <div class="pt-2">
            <div>
                <span class="little-text text-bold">
                    Examen:
                </span>
            </div>
            <div>
                <a href="{{ route('admin.exams.showQuestions', ["exam"=> $event->exam]) }}">
                    {{ $event->exam->title }}
                </a>
            </div>
        </div>

        <div class="pt-2">
            <div>
                <span class="little-text text-bold">
                    Examen de prueba:
                </span>
            </div>
            <div>
                {{ $event->testExam->title ?? '-' }}
            </div>
        </div>

        <div class="pt-2">
            <div>
                <span class="little-text text-bold">
                    Elearning:
                </span>
            </div>
            <div>
                {{ $event->eLearning->title ?? '-' }}
            </div>
        </div>

    </div>

    <div class="extra-info-container">

        <div class="mb-1">
            <div class="subt-text little-text">Curso: </div>
            <div>
                {{ $event->course->description }}
            </div>
        </div>

        <div class="pt-2">
            <div class="status-cont text-no-wrap d-flex justify-content-between align-items-center gap-1 mb-2">
                <span class="text-info-stat little-text"> Estado: &nbsp;</span>
                <span class="status {{ getStatusClass($event->active) }}">
                    {{ getStatusText($event->active) }}
                </span>
            </div>

            <div class="status-cont text-no-wrap d-flex justify-content-between gap-1 mb-2">
                <span class="text-info-stat little-text"> Asistencias: &nbsp;</span>
                <span class="status {{ getStatusClass($event->flg_asist) }}">
                    {{ getStatusText($event->flg_asist) }}
                </span>
            </div>

            
            <div class="status-cont text-no-wrap d-flex justify-content-between gap-1 mb-2">
                <span class="text-info-stat little-text"> Encuesta ficha sintomatológica: &nbsp;</span>
                <span class="status {{ getStatusClass($event->flg_survey_course) }}">
                    {{ getStatusText($event->flg_survey_evaluation) }}
                </span>
            </div>

            
            <div class="status-cont text-no-wrap d-flex justify-content-between gap-1 mb-2">
                <span class="text-info-stat little-text"> Encuesta de satisfacción: &nbsp;</span>
                <span class="status {{ getStatusClass($event->flg_survey_evaluation) }}">
                    {{ getStatusText($event->flg_survey_evaluation) }}
                </span>
            </div>
        </div>

        <div class="pt-1">
            <div class="d-flex">
                <div class="col-6 p-0">
                    <span class="little-text">
                        N° de enunciados: 
                    </span>
                    <span>
                        {{ $event->questions_qty }}
                    </span>
                </div>
                <div class="col-6 p-0 text-right">
                    <span class="little-text">
                        Puntuación mínima: 
                    </span>
                    <span>  
                        {{ $event->min_score }}
                    </span>
                </div>
            </div>
        </div>

        <div class="pt-2">
            <div class="d-flex justify-content-between align-items-center gap-1">
                <span class="little-text text-bold">
                    Fecha de creación:
                </span>
                <span>
                    {{ $event->created_at }}
                </span>
            </div>
            <div class="d-flex justify-content-between align-items-center gap-1 mt-1">
                <span class="little-text text-bold">
                    Fecha de actualización:
                </span>
                <span>
                    {{ $event->updated_at }}
                </span>
            </div>
        </div>

    </div>

    <div class="action-box info-element-box">

        <div class="btn-action-container">
            <span id="event-edit-btn" class="edit-btn editEvent-btn" 
            data-url="{{ route('admin.events.update', $event) }}"
            data-send="{{ route('admin.events.edit', $event) }}">
                <i class="fa-solid fa-pen-to-square"></i>
            </span>
            @if(
            $event->certifications_count == 0 &&
            $event->user_surveys_count == 0
            )
            <span class="delete-btn deleteEvent-btn" data-url="{{ route('admin.events.destroy', $event) }}">
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