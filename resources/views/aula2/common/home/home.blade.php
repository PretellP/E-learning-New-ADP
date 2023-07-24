@extends('aula2.common.layouts.masterpage')

@section('content')


<div class="row content">


    <div class="col-lg-8 publishings">
        <div class="card page-title-container">
            <div class="card-header">
                <div class="total-width-container">
                    <h4>INICIO</h4>
                </div>
            </div>
        </div>

        <div class="card-body publishing-boxes-container card z-index-2 g-course-flex">

            <div class="tight-publishing-container">
                @forelse ($publishings as $publishing)

                <div class="publishing-box card">
                    <div class="card-body">
                        <div class="box-content-info-user">
                            <hr>
                            <div class="box-flex-align-info">
                                <div class="avatar-img">
                                    <i class="fa-solid fa-circle-user"></i>
                                </div>
                                <div class="box-publication-info">
                                    <div class="publishing-title">
                                        {{$publishing->title}}
                                    </div>
                                    <div class="publishing-name-time">
                                        <span class="publishing-username">
                                            {{strtolower((getUserFromId($publishing->user_id))->name)}}
                                        </span>
                                        <i class="fa-solid fa-circle fa-2xs"></i>
                                        <span class="publishing-difftime">
                                            {{getDiffForHumansFromTimestamp($publishing->publication_time)}}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="publishing-text-content">
                                {{$publishing->content}}
                            </div>
                        </div>

                        <div class="box-publishing-img">
                            <img src="{{asset($publishing->url_img)}}" alt="">
                        </div>

                        <div class="box-publishing-footer">
                        </div>
                    </div>
                </div>

                @empty

                <h4 class="text-center">
                    Aún no hay publicaciones
                </h4>

                @endforelse
            </div>

        </div>
    </div>


    <div class="col-lg-4 recomended-courses">
        <div class="card gradient-bottom">
            <div class="card-header">
                <div class="total-width-container">
                    <h4>Cursos Recomendados</h4>
                </div>
            </div>
            <div class="card-body">
                <ul class="list-unstyled list-unstyled-border">

                    @for ($i = 0; $i < 5; $i++)

                    <li class="media">
                        <div class="media-body">
                            <div class="img-course">

                            </div>

                            <div class="course-description-container">
                                <div class="text-content-1">

                                </div>
                                <div class="text-content-2">

                                </div>
                                <div class="text-content-3">

                                </div>
                            </div>
                        </div>
                    </li>

                    @endfor
               

                </ul>
            </div>
        </div>
    </div>
</div>

@endsection