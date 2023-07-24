@extends('aula2.common.layouts.masterpage')

@section('content')



<div class="content global-container">

    <div class="card page-title-container free-courses">
        <div class="card-header">
            <div class="total-width-container">
                <h4>CURSOS LIBRES</h4>
            </div>
        </div>
    </div>

    <div class="card-body body-global-container card z-index-2 g-course-flex">


        <div class="course-category-container">

            @foreach ($categories as $category)
                
                <div class="category-card">
                    <img src="{{asset($category->url_img)}}" alt="{{$category->description}}">
                    <div class="category-title-container">
                        <div class="box-title">
                            <div class="upper-text">
                                CURSOS DE 
                            </div>
                            <div class="title">
                                {{$category->description}}
                            </div>
                            <a href="{{route('aula.freecourse.showCategory', $category)}}" class="category-start">
                                Ver más
                            </a>
                        </div>
                    </div>
                </div>

            @endforeach

        </div>


        <div class="card page-title-container sub-content">
            <div class="card-header">
                <div class="total-width-container">
                    <h4>CURSOS RECOMENDADOS</h4>
                </div>
            </div>
        </div>


        <div class="courses-cards-container">

            @foreach ($courses as $course)

            <div class="card course-card">
                <div class="course-img-container">
                    <img class="card-img-top course-img" src="{{asset($course->url_img)}}"
                        alt="{{$course->description}}">
                </div>


                <div class="card-body">

                    <div class="start-button-container">
                        <a href="">
                            Iniciar &nbsp;
                            <i class="fa-solid fa-chevron-right"></i>
                        </a>
                    </div>

                    <div class="course-title-box">
                        {{$course->description}}
                    </div>

                    <div class="course-info-box">
                        <div class="hours-box">
                            <i class="fa-regular fa-clock"></i>
                            Duración: {{getFreeCourseTotalTime($course)}}
                        </div>
                    </div>

                </div>

            </div>

            @endforeach

        </div>


    </div>



</div>


@endsection