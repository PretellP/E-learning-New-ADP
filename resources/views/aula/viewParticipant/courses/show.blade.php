@extends('aula.common.courses.layout')

@section('page-info', 'Menú Principal')

@section('courseContent')

<div class="link-navigation-pages mt-4">
    <a href="{{route('aula.course.index')}}">
        <i class="fa-solid fa-arrow-left"></i>
        Volver a los cursos
    </a>

    / Menú
</div>

<div class="row mt-5 navigation-boxes-container">

    <a href="{{route('aula.course.folder.index', $course)}}" class="link-box-navigation-course">
        <div class="navigation-box content card">
            <div class="img-container">
                <img src="{{asset('assets/aula/img/courses/content.png')}}" alt="">
            </div>
            <div class="text-nav-container">
                <span>
                    Contenido
                </span>
                <span class="bg-nav-course-box"></span>
            </div>
        </div>
    </a>

    <a href="{{route('aula.course.onlinelesson.index', $course)}}" class="link-box-navigation-course">
        <div class="navigation-box online-lesson card">
            <div class="img-container">
                <img src="{{asset('assets/aula/img/courses/online-lesson.png')}}" alt="">
            </div>
            <div class="text-nav-container">
                <span>
                    Clase Virtual
                </span>
                <span class="bg-nav-course-box"></span>
            </div>
        </div>
    </a>

    <a href="{{route('aula.course.evaluation.index', $course)}}" class="link-box-navigation-course">
        <div class="navigation-box evaluation card">
            <div class="img-container">
                <img src="{{asset('assets/aula/img/courses/quiz.png')}}" alt="">
            </div>
            <div class="text-nav-container">
                <span>
                    Evaluación Virtual
                </span>
                <span class="bg-nav-course-box"></span>
            </div>
        </div>
    </a>

</div>

@endsection