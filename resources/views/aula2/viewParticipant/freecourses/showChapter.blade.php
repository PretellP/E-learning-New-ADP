@extends('aula2.common.layouts.masterpage')

@section('content')


<div class="content global-container">

    <div class="card page-title-container free-courses">
        <div class="card-header">
            <div class="total-width-container">
                <h4> Cursos libres: {{$course->description}} </h4>
            </div>
        </div>
    </div>


    <div class="card-body body-global-container freecourse-view card z-index-2 g-course-flex">

        <div class="video-container">
            <video controls preload='auto' class="video-js" data-setup='{
                "fluid": true,
                "playbackRates": [0.5, 1, 1.5, 2]
            }'>
                <source src="{{asset($current_chapter->url_video)}}">
            </video>
        </div>


        <div class="lateral-menu">

            <div class="course-header">
                <div class="img-container">
                    <img src="{{asset($course->url_img)}}" alt="{{$course->description}}">
                </div>
                <div class="title">
                    {{$course->description}}
                </div>
            </div>

            <div class="info-head-freecourse">
                Módulos
            </div>

            <div class="accordion" id="lateral-menu-sections">

                @php
                $chapter_count = 1;
                @endphp

                @foreach ($sections as $key => $section)

                <div class="card section-accordion">

                    <div class="card-header" id="heading-{{$section->id}}">

                        <button class="btn btn-link btn-block text-left button-section-tab" type="button"
                            data-toggle="collapse" data-target="#collapse-{{$section->id}}" aria-expanded="false"
                            aria-controls="collapse-{{$section->id}}">
                            <div class="info-section-txt">
                                <span>
                                    {{$key+1}}. {{$section->title}}
                                </span>
                                <i class="fa-solid fa-chevron-down"></i>
                            </div>

                            <div class="info-count">
                                0/{{count($section->sectionChapters)}}
                                @php
                                $section_duration = 0;
                                foreach ($section->sectionChapters as $chapter_duration) {
                                $section_duration += $chapter_duration->duration;
                                }
                                @endphp
                                | {{$section_duration}} min
                            </div>
                        </button>

                    </div>

                    <div id="collapse-{{$section->id}}"
                        class="collapse collapse-sections {{getShowSection($current_chapter, $section)}}"
                        aria-labelledby="heading-{{$section->id}}" data-parent="#lateral-menu-sections">

                        @foreach ($section->sectionChapters as $chapter)

                        <div class="card-body @if($chapter->id == $current_chapter->id)active @endif">

                            @if($chapter->id != $current_chapter->id)
                            <form method="POST"
                                action="{{route('aula.freecourse.update', [$current_chapter, 'new_chapter' => $chapter])}}">
                                @method('PATCH')
                                @csrf
                            @else
                            <form action=''>
                            @endif

                                <button class="btn-next-chapter" type="submit">

                                    <div>
                                        {{-- <i class="fa-solid fa-circle-check"></i> --}}
                                        <i class="fa-regular fa-circle"></i>
                                    </div>

                                    <div>
                                        <div class="chapter-title">
                                            <span><i class="fa-solid fa-circle fa-2xs"></i></span> &nbsp;
                                            <span>{{$chapter_count}}. </span>
                                            {{$chapter->title}}
                                        </div>

                                        <div>
                                            <span><i class="fa-solid fa-desktop"></i></span> &nbsp;
                                            {{$chapter->duration}} min.
                                        </div>
                                    </div>

                                </button>

                            </form>

                        </div>
                        @php
                        $chapter_count++;
                        @endphp
                        @endforeach

                    </div>

                </div>

                @endforeach


            </div>


        </div>

    </div>



</div>

@endsection