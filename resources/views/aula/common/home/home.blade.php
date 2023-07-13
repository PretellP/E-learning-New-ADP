@extends('aula.common.layouts.dashboard')

@section('sub_content')

<div class="row general-container-page-info">
    <div class="body-container-page-info">

        <div class="col-12 mb-0">
            <div class="card pt-5 box-container-info">
                <div class="welcome-page-info">
                    <span>Bienvenido,</span>
                </div>
                <div class="names-page-info">
                    <span>
                        {{strtolower(Auth::user()->name)}},
                        {{strtolower(Auth::user()->paternal)}}
                        {{strtolower(Auth::user()->maternal)}}
                    </span>
                </div>
                <hr class="divider-page-info">
                <div class="extra-page-info">
                    <span>
                        Estás viendo los anuncios más recientes
                    </span>
                </div>
            </div>
        </div>

    </div>


</div>

<div class="row">

    <div class="body-page-container col-12">

        <div class="publishing-boxes-container card z-index-2 g-course-flex">

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
</div>


@endsection