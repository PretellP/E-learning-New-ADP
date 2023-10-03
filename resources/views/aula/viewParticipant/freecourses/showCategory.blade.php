@extends('aula.common.layouts.masterpage')

@section('content')



<div class="content global-container">

    <div class="card page-title-container free-courses">
        <div class="card-header">
            <div class="total-width-container">
                <h4> Cursos libres: {{$category->description}} </h4>
            </div>
        </div>
    </div>

    <div class="card-body body-global-container card z-index-2 principal-container">

        <div class="courses-cards-container">

            @forelse ($courses as $course)



            <div class="card course-card">
                <div class="course-img-container">
                    <img class="card-img-top course-img" src="{{verifyImage($course->file)}}"
                        alt="{{$course->description}}">
                </div>


                <div class="card-body">

                    <div class="start-button-container freecourses">
                        <form method="POST" action="{{route('aula.freecourse.start', $course)}}">
                            @csrf
                            <button type="submit">
                                Ingresar &nbsp;
                                <i class="fa-solid fa-chevron-right"></i>
                            </button>
                        </form>

                    </div>

                    <div class="course-title-box">
                        {{$course->description}}
                    </div>

                    <div class="course-info-box">
                        <div class="category-box">
                            <div>
                                (Categoría)
                            </div>
                            <div>
                                <i class="fa-solid fa-table-cells-large"></i>
                                {{$course->courseCategory->description}}
                            </div>
                        </div>
                    </div>

                    <div class="course-info-box">
                        <div class="hours-box">
                            <i class="fa-regular fa-clock"></i>
                            Duración: {{getFreeCourseTime($course->course_chapters_sum_duration)}}
                        </div>
                    </div>

                </div>

            </div>

            @empty

            <h4 class="text-center empty-records-message"> Aún no hay cursos en esta categoría </h4>

            @endforelse

        </div>


    </div>



</div>


@endsection