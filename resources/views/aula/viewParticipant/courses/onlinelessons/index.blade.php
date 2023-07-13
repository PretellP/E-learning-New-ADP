@extends('aula.common.courses.layout')

@section('page-info', 'Clases Online')

@section('courseContent')

<div class="link-navigation-pages mt-4">
    <a href="{{route('aula.course.index')}}">
        <i class="fa-solid fa-arrow-left"></i>
        Volver a los cursos
    </a>
    <a href="{{route('aula.course.participant.show', $course)}}">
        / Menú
    </a>

    / Clases Online
</div>


<div class="row mt-5 w-100">

    <div class="course-container online-lessons">

        <div class="message-lesson-container">
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
            $event = $certification->event()->first();
            $instructor = $event->user()->first();
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

@endsection