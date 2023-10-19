<div class="container-xxl py-5 category">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title bg-white text-center text-primary px-3">Cursos Libres</h6>
            <h1 class="mb-5">Categorías</h1>
        </div>

        <div class="d-flex flex-column gap-3">
            @php
                $delay = 0.1;
            @endphp

            @forelse ($categories as $category)

            @php
                $openRow = ($loop->iteration - 1) % 2 == 0 ||
                            $loop->first;
                $closeRow = $loop->iteration % 2 == 0 ||
                            $loop->last;
            @endphp

            @if ($openRow)
            <div class="row g-3 justify-content-center">
            @endif

                <div class="col-lg-6 col-md-12">

                    <div class="row g-3">

                        <div class="col-lg-12 col-md-12 wow zoomIn" data-wow-delay="{{ $delay }}s">
                            <a class="position-relative d-block overflow-hidden" href="{{ route('home.freecourses.show', $category) }}" style="height: 240px;">
                                <img class="img-fluid img-cover" src="{{ verifyImage($category->file) }}" alt="">
                                <div class="bg-white text-center position-absolute bottom-0 end-0 py-2 px-3"
                                    style="margin: 1px;">
                                    <h5 class="m-0">
                                        {{ ucwords(mb_strtolower($category->description), 'UTF-8') }}
                                    </h5>
                                    <small class="text-primary">
                                        {{ $category->courses_count }} cursos
                                    </small>
                                </div>
                            </a>
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

            <h4 class="text-center empty-records-message"> No hay categorías que mostrar </h4>

            @endforelse

        </div>

       

    </div>
</div>