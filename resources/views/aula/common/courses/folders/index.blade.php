@extends('aula.common.courses.layout')

@section('page-info', 'Contenido')

@section('courseContent')

<div class="link-navigation-pages mt-4">
    <a href="{{route('aula.course.index')}}">
        <i class="fa-solid fa-arrow-left"></i>
        Volver a los cursos
    </a>
    <a href="{{route('aula.course.participant.show', $course)}}">
        / Menú
    </a>

    / Contenido
</div>

<div class="row mt-5 w-100">

    <div class="folders-container">

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

@endsection