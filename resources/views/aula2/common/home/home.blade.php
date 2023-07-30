@extends('aula2.common.layouts.masterpage')

@section('extra-head')

<link rel="stylesheet" href="{{asset('assets/aula2/modules/owlcarousel2/dist/assets/owl.carousel.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/aula2/modules/owlcarousel2/dist/assets/owl.theme.default.min.css')}}">

@endsection

@section('content')


<div class="row content">


    <div class="publishings">
        <div class="card page-title-container">
            <div class="card-header">
                <div class="total-width-container">
                    <h4>INICIO</h4>
                </div>
            </div>
        </div>

        <div class="card-body publishing-boxes-container card z-index-2 g-course-flex">

            <div class="carousel-container">
                <div id="publishings-owlcarousel" class="publishings-owlcarousel owl-carousel owl-theme slider">
                    @foreach ($bannerPublishings as $banner)
                        <img class='banner-img' src="{{asset($banner->url_img)}}" alt="">
                    @endforeach
                </div>
            </div>

            <div class="card page-title-container sub-content">
                <div class="card-header">
                    <div class="total-width-container">
                        <h4>NOTICIAS</h4>
                    </div>
                </div>
            </div>

            <div class="tight-publishing-container">
                @forelse ($cardPublishings as $card)

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
                                        {{$card->title}}
                                    </div>
                                    <div class="publishing-name-time">
                                        <span class="publishing-username">
                                            {{strtolower(($card->user->name))}}
                                        </span>
                                        <i class="fa-solid fa-circle fa-2xs"></i>
                                        <span class="publishing-difftime">
                                            {{getDiffForHumansFromTimestamp($card->publication_time)}}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="publishing-text-content">
                                {!! $card->content !!}
                            </div>
                        </div>

                        <div class="box-publishing-img">
                            <img src="{{asset($card->url_img)}}" alt="">
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


@section('extra-script')

<script src="{{asset('assets/aula2/modules/owlcarousel2/dist/owl.carousel.min.js')}}"></script>

@endsection