@extends('aula.common.layouts.dashboard')

@section('sub_content')

<div class="row general-container-page-info">
    <div class="body-container-page-info">

        <div class="col-12 mb-0">
            <div class="card pt-5 box-container-info">
                <div class="welcome-page-info">
                    <span>Estás en el curso:</span>
                </div>
                <div class="names-page-info">
                    <span>
                        {{$course->description}}
                    </span>
                </div>
                <hr class="divider-page-info">
                <div class="extra-page-info">
                    <span>
                        @yield('page-info')
                    </span>
                </div>

                <div class="extra-navigation-menu">
                    <div class="box-extra-navigation {{setActive('aula.course.folder.*')}}">
                        <a href="{{route('aula.course.folder.index', $course)}}">
                            <i class="fa-regular fa-folder-open"></i>
                        </a>
                    </div>
                    <div class="box-extra-navigation {{setActive('aula.course.onlinelesson.*')}}">
                        <a href="{{route('aula.course.onlinelesson.index', $course)}}">
                            <i class="fa-solid fa-chalkboard-user"></i>
                        </a>
                    </div>
                    <div class="box-extra-navigation {{setActive('aula.course.evaluation.*')}}">
                        <a href="{{route('aula.course.evaluation.index', $course)}}">
                            <i class="fa-solid fa-file-pen"></i>
                        </a>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>



<div class="row">

    <div class="body-page-container col-12">

        <div class="card z-index-2 g-course-flex">

            @yield('courseContent')

        </div>
    </div>

</div>

@endsection