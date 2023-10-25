@extends('aula.common.layouts.masterpage')

@section('extra-head')

<link rel="stylesheet" href="{{asset('assets/common/modules/owlcarousel2/dist/assets/owl.carousel.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/common/modules/owlcarousel2/dist/assets/owl.theme.default.min.css')}}">

@endsection

@section('content')

@php
$maxPage = $cardPublishings->lastPage();
@endphp


<div class="row content">


    <div class="publishings">
        <div class="card page-title-container">
            <div class="card-header">
                <div class="total-width-container">
                    <h4>INICIO</h4>
                </div>
            </div>
        </div>

        <div class="card-body publishing-boxes-container card z-index-2 principal-container">

            <div class="carousel-container">
                <div id="publishings-owlcarousel" class="publishings-owlcarousel owl-carousel owl-theme slider">
                    @forelse ($bannerPublishings as $banner)
                    <div>
                        {!! $banner->content !!}
                        <img class='banner-img' src="{{verifyImage($banner->file)}}" alt="">
                    </div>
                    @empty
                    <h4 class="text-center empty-records-message">
                        Aún no hay publicaciones
                    </h4>
                    @endforelse
                </div>
            </div>

            <div class="card page-title-container sub-content">
                <div class="card-header">
                    <div class="total-width-container">
                        <h4>NOTICIAS</h4>
                    </div>
                </div>
            </div>

            <div class="tight-publishing-container" id="card-publishing-container">

                @if ($cardPublishings->isEmpty())
                <h4 class="text-center empty-records-message">
                    Aún no hay publicaciones
                </h4>
                @else
                @include('aula.common.home.partials.boxes.publishings')
                @endif

            </div>

            <div class="text-center" id="loader-container" style="display: none">
                <span>
                    <img src="{{ asset('assets/common/images/loader.gif') }}" alt="loader" style="max-width: 160px;">
                </span>
                <div>
                    <i>
                        <b>
                            Cargando más publicaciones...
                        </b>
                    </i>
                </div>
            </div>

            <h4 class="text-center empty-records-message" id="end-data-records" style="display: none">
                No hay más publicaciones
            </h4>

        </div>
    </div>

</div>

@endsection


@section('extra-script')

<script src="{{asset('assets/common/modules/owlcarousel2/dist/owl.carousel.min.js')}}"></script>

<script>
    $(function() {

        function loadPublishings(page, limitReached)
        {
            if (!limitReached) {
                $.ajax({
                url: '?page=' + page,
                type: 'GET',
                beforeSend: function()
                {
                    $("#loader-container").show()
                }
                })
                .done(function(data){
                    $("#loader-container").hide()
                    $('#card-publishing-container').append(data.html)
                })
            }
            else {
                $('#end-data-records').show()
            }
        }

        var page = 1;
        var maxPage = @json($maxPage);
        var limitReached = false

        $(window).scroll(function(){
            if (!limitReached) {
                if ($(window).scrollTop() + $(window).height() + 100 >= $(document).height()) {
                    if (page < maxPage) {
                        page++
                    }
                    if (page == 1) {
                        limitReached = true;
                    }
                    loadPublishings(page, limitReached)
                    limitReached = (page == maxPage) ? true : false;
                }
            } else {
                $('#end-data-records').show()
            }
        })
    })


</script>

@endsection