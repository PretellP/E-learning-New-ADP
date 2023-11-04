<div class="container-xxl py-5 courses-container">
    <div class="container">

        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title bg-white text-center text-primary px-3">Cursos Libres</h6>
            <h1 class="mb-5">Cursos disponibles</h1>
        </div>

        @php
        $delay = 0.1;
        @endphp

        @forelse ($freeCourses as $freeCourse)
        @php
        $openRow =  ($loop->iteration - 1) % 3 == 0 ||
                    $loop->first;
        $closeRow = $loop->iteration % 3 == 0 ||
                    $loop->last;

        @endphp

        @if ($openRow)
        <div class="row g-4 justify-content-center">
        @endif

            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="{{ $delay }}s">
                <div class="course-item bg-light">
                    <div class="position-relative image-inner-container overflow-hidden">
                        <a href="{{ route('aula.freecourse.showCategory', ["category" => $freeCourse->courseCategory]) }}">
                            <img class="img-fluid" src="{{ verifyImage($freeCourse->file) }}" alt="">
                        </a>
                    </div>
                    <div class="text-center p-4 pb-0">
                      
                        <h5 class="mb-4">
                            {{ $freeCourse->description }}
                        </h5>
                    </div>

                    <div class="d-flex border-top">
                        <small class="flex-fill text-center border-end py-2"><i
                                class="fa fa-clock text-primary me-2"></i>
                                {{getFreeCourseTime($freeCourse->course_chapters_sum_duration)}}
                            </small>
                        <small class="flex-fill text-center py-2">
                            <i class="fa-solid fa-tv text-primary me-2"></i>
                            {{ $freeCourse->course_chapters_count }}
                            Capítulos
                        </small>
                    </div>
                </div>
            </div>

        @if ($closeRow)
        </div>
        @endif
        @php
            $delay += 0.2;
        @endphp
        @empty

        <h4 class="text-center empty-records-message"> No hay cursos que mostrar </h4>

        @endforelse

    </div>
</div>