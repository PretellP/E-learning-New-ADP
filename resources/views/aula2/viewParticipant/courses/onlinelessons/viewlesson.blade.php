@extends('aula2.common.layouts.masterpage')

@section('content')

<div class="row upper-info-container">

    <div class="col-12">
        <div class="card card-upper-info">
            <div class="card-upper-info-items principal">
                {{$course->description}}:
            </div>

            <div class="card-upper-info-items extra text-uppercase">
                {{$room->description}}
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
                    <a href="{{route('aula.course.onlinelesson.index', $course)}}"> CLASE VIRTUAL </a> /

                    {{$room->description}}

                </h4>
            </div>
        </div>
    </div>


    <div class="card-body body-global-container card z-index-2 g-course-flex">
        <div class=" mt-5 course-container online-lessons">

            <iframe class="zoom-meeting" src="{{$room->url_zoom}}"
                allow="livestreaming,sharedvideo,chat,raisehand,settings,microphone,camera,desktop,fullscreen,shortcuts,tileview,mute-everyone"
                frameborder="0" marginwidth="0" marginheight="0" scrolling="no">
            </iframe>

        </div>
    </div>



</div>




@endsection