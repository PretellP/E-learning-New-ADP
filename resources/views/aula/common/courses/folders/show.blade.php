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

    <div class="mb-5 folder-btn-back">
        <a class="btn-folder-home" href="{{route('aula.course.folder.index', $course)}}">
            <i class="fa-solid fa-house fa-xl"></i>
        </a>
        @foreach ($parentFoldersCollection as $parent_folder)
        <i class="fa-solid fa-chevron-right"></i>
        <a href="{{route('aula.course.folder.show', [$course, $parent_folder])}}">
            {{$parent_folder->name}}
        </a>
        @endforeach
        <i class="fa-solid fa-chevron-right"></i>
        <a href="{{route('aula.course.folder.show', [$course, $folder])}}"> {{$folder->name}} </a>
    </div>

    <div class="subfolder-text-info">
        Subcarpetas
    </div>

    <hr>

    <div class="subfolders-box mb-4 folders-container">

        @forelse ($subFolders as $subFolder)

        <a href="{{route('aula.course.folder.show', [$course, $subFolder])}}" class="folder-link">
            <div class="folder-block subfolder">
                <img class="card-img-top folder-img" src="{{asset('assets/common/images/subfolder.png')}}">
                <div class="card-body">
                    <p class="card-text">{{$subFolder->name}}</p>
                </div>
            </div>
        </a>

        @empty

        <h4 class="text-center">Aún no hay subcarpetas
            <img src="{{asset('assets/common/images/emptyfolder.png')}}" alt="">
        </h4>
     

        @endforelse
    </div>

    <hr>



    <div class="files-container">

        <ul>
            @foreach ($files as $file)

            <li>
                <a href="{{route('aula.file.download', $file)}}">
                    {{$file->filename}}
                </a>
            </li>

            @endforeach
        </ul>


    </div>

</div>

@endsection