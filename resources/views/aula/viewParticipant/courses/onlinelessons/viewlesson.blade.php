@extends('aula.common.courses.layout')

@section('page-info')
    {{$room->description}}
@endsection

@section('courseContent')

<div class="link-navigation-pages mt-4">
    <a href="{{route('aula.course.index')}}">
        <i class="fa-solid fa-arrow-left"></i>
        Volver a los cursos
    </a>
    <a href="{{route('aula.course.participant.show', $course)}}">
        / Menú
    </a>

    <a href="{{route('aula.course.onlinelesson.index', $course)}}">
        / Volver a las Salas
    </a>

    / {{$room->description}}
</div>


<div class="row mt-5 w-100">

    <div class="course-container">

        <iframe class="zoom-meeting" src="{{$room->url_zoom}}"
            allow="livestreaming,sharedvideo,chat,raisehand,settings,microphone,camera,desktop,fullscreen,shortcuts,tileview,mute-everyone"
            frameborder="0" marginwidth="0" marginheight="0" scrolling="no">
        </iframe>

    </div>

</div>

@endsection