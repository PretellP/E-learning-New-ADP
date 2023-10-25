@foreach ($cardPublishings as $card)

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
            <img src="{{verifyImage($card->file)}}" alt="">
        </div>
    </div>
</div>

@endforeach
