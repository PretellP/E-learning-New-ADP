@extends('aula2.common.layouts.masterpage')

@section('content')

<div class="row upper-info-container">

    <div class="col-12">
        <div class="card card-upper-info">
            <div class="card-upper-info-items principal">
                {{$course->description}}:
            </div>

            <div class="card-upper-info-items extra text-uppercase">
                Clase Virtual
            </div>
        </div>
    </div>

</div>



<div class="content global-container">

    <div class="card page-title-container">
        <div class="card-header">
            <div class="total-width-container">
                <h4>
                    <a href="{{route('aula.course.index')}}">
                        <i class="fa-solid fa-circle-chevron-left"></i> Cursos
                    </a>
                    <span> / {{$course->description}} </span> /
                    <a href="{{route('aula.course.participant.show', $course)}}">
                        MENÚ
                    </a> /
                    CLASE VIRTUAL
                </h4>
            </div>
        </div>
    </div>


    <div class="card-body body-global-container card z-index-2 g-course-flex">
        <div class="course-container online-lessons">

            <div class="mt-5 message-lesson-container">
                <div class="message-title">
                    Salas Asignadas
                </div>
                <div class="message-content">
                    <i class="fa-solid fa-triangle-exclamation"></i> &nbsp;
                    Estimado usuario, si no visualiza el curso deseado, asegúrese de tener sala asignada.
                </div>
            </div>
           
    
            <div class="rooms-general-container">
    
                <div class="room-row-container lessons-table-head">
                    <div class="row-data">
                        Nombre del Evento
                    </div>
                    <div class="row-data">
                        Tipo
                    </div>
                    <div class="row-data">
                        Instructor
                    </div>
                    <div class="row-data">
                        Fecha
                    </div>
                    <div class="row-data">
                        Sala
                    </div>
                    
                </div>
    
                @foreach ($certifications as $certification)
    
                @php
                $event = $certification->event;
                $instructor = $event->user;
                @endphp
                    
                @if ($event->date == getCurrentDate())
    
                <div class="room-row-container">
                    <div class="row-data">
                        {{$event->description}}
                    </div>
                    <div class="row-data">
                        {{$event->type}}
                    </div>
                    <div class="row-data">
                        {{$instructor->name}}
                        {{$instructor->paternal}}
                    </div>
                    <div class="row-data">
                        {{$event->date}}
                    </div>
                   
                    <div class="row-data room-link">
                        <a href="{{route('aula.course.onlinelesson.show', $event)}}">
                            <i class="fa-solid fa-chalkboard-user"></i>
                        </a>
                    </div>
                </div>
    
                @endif
    
                @endforeach
    
                
            </div>
    
    
    
        </div>
    
    </div>  

</div>

@endsection