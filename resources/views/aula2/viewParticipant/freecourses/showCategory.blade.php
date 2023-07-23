@extends('aula2.common.layouts.masterpage')

@section('content')

<div class="row upper-info-container">

    <div class="col-12">
        <div class="card card-upper-info">
            <div class="card-upper-info-items principal">
                CURSOS LIBRES
            </div>

            <div class="card-upper-info-items extra text-uppercase">
                {{$category->description}}
            </div>
        </div>
    </div>

</div>


<div class="content global-container">

    <div class="card page-title-container free-courses">
        <div class="card-header">
            <div class="total-width-container">
                <h4> Cursos libres: {{$category->description}} </h4>
            </div>
        </div>
    </div>

    <div class="card-body body-global-container card z-index-2 g-course-flex">

        <div class="courses-cards-container">

            @forelse ($courses as $course)



            <div class="card course-card">
                <div class="course-img-container">
                    <img class="card-img-top course-img" src="{{asset($course->url_img)}}"
                        alt="{{$course->description}}">
                </div>


                <div class="card-body">

                    <div class="start-button-container freecourses">
                        <form method="POST" action="{{route('aula.freecourse.start', $course)}}"> 
                            @csrf
                            <button type="submit">
                                Iniciar &nbsp;
                                <i class="fa-solid fa-chevron-right"></i>
                            </button>
                        </form>
                       
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

            @empty

            <h2 class="text-center w-100"> Aún no hay cursos en esta categoría </h2>

            @endforelse

        </div>


    </div>



</div>


@endsection