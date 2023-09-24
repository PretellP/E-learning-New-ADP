@extends('aula.common.layouts.masterpage')

@section('content')

<div class="content global-container">

    <div class="card page-title-container">
        <div class="card-header">
            <div class="total-width-container">
                <h4>CURSOS LIBRES</h4>
            </div>
        </div>
    </div>

    <div class="card-body body-global-container card z-index-2 principal-container">

        <div class="course-category-container">

            @foreach ($categories as $category)
                
                <div class="category-card">
                    <img src="{{verifyImage($category->file)}}" alt="{{$category->description}}">
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

        {{--- SIGUIENDO  ---}}

        <div class="card page-title-container sub-content">
            <div class="card-header">
                <div class="total-width-container">
                    <h4>SIGUIENDO</h4>
                </div>
            </div>
        </div>

        @forelse ($pendingCourses as $pendingCourse)

        <div class="courses-cards-container">

            <div class="card course-card">
                <div class="course-img-container">
                    <img class="card-img-top course-img" src="{{verifyImage($pendingCourse->file)}}"
                        alt="{{$pendingCourse->description}}">
                </div>

                <div class="card-body">

                    <div class="start-button-container freecourses">
                        <form method="POST" action="{{route('aula.freecourse.start', ["course" => $pendingCourse])}}#chapter-title-head"> 
                            @csrf 
                            <button type="submit">
                                Continuar &nbsp;
                                <i class="fa-solid fa-chevron-right"></i>
                            </button>
                        </form>
                    </div>

                    <div class="course-title-box">
                        {{$pendingCourse->description}}
                    </div>

                    <div class="course-info-box">
                        <div class="category-box">
                            <div>
                                (Categoría)
                            </div>
                            <div>
                                <i class="fa-solid fa-table-cells-large"></i> 
                                {{$pendingCourse->courseCategory->description}}
                            </div>
                        </div>
                    </div>

                    <div class="course-info-box">
                        <div class="hours-box">
                            <i class="fa-regular fa-clock"></i>
                            Duración: {{getFreeCourseTime($pendingCourse->course_chapters_sum_duration)}}
                        </div>
                    </div>

                </div>

            </div>

        </div>
            
        @empty

        <div class="courses-cards-container">

            <div class="info-empty-section">
                <h4> Aquí aparecerán los cursos que has iniciado </h4>
                <i class="fa-solid fa-flag-checkered"></i>
            </div>
         
        </div>
            
        @endforelse

 


        {{--- CURSOS FINALIZADOS  ---}}


        <div class="card page-title-container sub-content">
            <div class="card-header">
                <div class="total-width-container">
                    <h4>CURSOS FINALIZADOS</h4>
                </div>
            </div>
        </div>

        <div class="courses-cards-container">

            @forelse ($finishedCourses as $finishedCourse)

            <div class="card course-card">
                <div class="course-img-container">
                    <img class="card-img-top course-img" src="{{verifyImage($finishedCourse->file)}}"
                        alt="{{$finishedCourse->description}}">
                </div>


                <div class="card-body">

                    <div class="start-button-container freecourses">
                        <form method="POST" action="{{route('aula.freecourse.start', ["course" => $finishedCourse])}}#chapter-title-head"> 
                            @csrf 
                            <button type="submit">
                                Ingresar &nbsp;
                                <i class="fa-solid fa-chevron-right"></i>
                            </button>
                        </form>
                    </div>

                    <div class="course-title-box">
                        {{$finishedCourse->description}}
                    </div>

                    <div class="course-info-box">
                        <div class="category-box">
                            <div>
                                (Categoría)
                            </div>
                            <div>
                                <i class="fa-solid fa-table-cells-large"></i> 
                                {{$finishedCourse->courseCategory->description}}
                            </div>
                        </div>
                    </div>

                    <div class="course-info-box">
                        <div class="hours-box">
                            <i class="fa-regular fa-clock"></i>
                            Duración: {{getFreeCourseTime($finishedCourse->course_chapters_sum_duration)}}
                        </div>
                    </div>

                </div>

            </div>
                
            @empty

            <div class="info-empty-section">
                <h4> Aún no se ha finalizado ningún curso </h4>
                <i class="fa-solid fa-hourglass-start"></i>
            </div>
                
            @endforelse

          
           
        </div>



        {{--- CURSOS RECOMENTADOS  ---}}


        <div class="card page-title-container sub-content">
            <div class="card-header">
                <div class="total-width-container">
                    <h4>   <i class="fa-solid fa-star"></i> &nbsp; RECOMENDADOS</h4>
                </div>
            </div>
        </div>
        


        <div class="courses-cards-container">

            @foreach ($recomendedCourses as $recomendedCourse)

            <div class="card course-card">
                <div class="course-img-container">
                    <img class="card-img-top course-img" src="{{verifyImage($recomendedCourse->file)}}"
                        alt="{{$recomendedCourse->description}}">
                </div>


                <div class="card-body">

                    <div class="start-button-container freecourses">
                        <form method="POST" action="{{route('aula.freecourse.start', ["course" => $recomendedCourse])}}#chapter-title-head"> 
                            @csrf 
                            <button type="submit">
                                Ingresar &nbsp;
                                <i class="fa-solid fa-chevron-right"></i>
                            </button>
                        </form>
                    </div>

                    <div class="course-title-box">
                        {{$recomendedCourse->description}}
                    </div>

                    <div class="course-info-box">
                        <div class="category-box">
                            <div>
                                (Categoría)
                            </div>
                            <div>
                                <i class="fa-solid fa-table-cells-large"></i> 
                                {{$recomendedCourse->courseCategory->description}}
                            </div>
                        </div>
                    </div>

                    <div class="course-info-box">
                        <div class="hours-box">
                            <i class="fa-regular fa-clock"></i>
                            Duración: {{getFreeCourseTime($recomendedCourse->course_chapters_sum_duration)}}
                        </div>
                    </div>

                </div>

            </div>

            @endforeach

        </div>





    </div>



</div>


@endsection