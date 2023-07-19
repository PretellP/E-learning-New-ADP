@extends('aula2.common.layouts.masterpage')

@section('content')

<div class="row upper-info-container">

    <div class="col-12">
        <div class="card card-upper-info">
            <div class="card-upper-info-items principal">
                {{$course->description}}
            </div>

            <div class="card-upper-info-items extra text-uppercase">
                CONTENIDO
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
                    CONTENIDO
                </h4>
            </div>
        </div>
    </div>


    <div class="card-body body-global-container card z-index-2 g-course-flex">

        <div class="mt-5 folders-container">

            @forelse ($folders as $folder)
    
            <a href="{{route('aula.course.folder.show', [$course, $folder])}}" class="folder-link">
                <div class="folder-block">
                    <img class="card-img-top folder-img" src="{{asset('assets/common/images/subfolder.png')}}"
                        alt="Card image cap">
                    <div class="card-body">
                        <p class="card-text">{{$folder->name}}</p>
                    </div>
                </div>
            </a>
    
            @empty
    
            <h4 class="text-center">
                Aún no hay carpetas
                <img src="{{asset('assets/common/images/emptyfolder.png')}}" alt=""> 
            </h4>
            
            @endforelse
    
        </div>

    </div>

</div>







@endsection