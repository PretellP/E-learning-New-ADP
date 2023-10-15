
<div class="container">

    <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
        <h6 class="section-title bg-white text-center text-primary px-3">Eventos</h6>
        <h2 class="mb-5">Eventos disponibles</h1>
    </div>

    @php
    $delay = 0.1;
    @endphp


    @foreach($events as $event)

    @php
    $openRow = ($loop->iteration - 1) % 3 == 0 ||
    $loop->first;
    $closeRow = $loop->iteration % 3 == 0 ||
    $loop->last;

    $participants_ids = $event->participants->pluck('id')->toArray();
    @endphp

    @if ($openRow)
    <div class="row g-4 justify-content-center">
        @endif

        <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="{{ $delay }}s">
            <div class="course-item bg-light">
                <div class="position-relative image-inner-container overflow-hidden">
                    <img class="img-fluid" src="{{ asset('assets/home/img/course-event-default.jpg') }}" alt="">
                    <div class="w-100 d-flex justify-content-center position-absolute bottom-0 start-0 mb-4">

                        @if(Auth::check() && in_array(Auth::user()->id, $participants_ids))
                            <a href="{{ route('aula.index') }}"
                                class="flex-shrink-0 btn btn-sm btn-success text-white px-4 py-2"
                                style="border-radius: 30px;">
                                <i class="fa-regular fa-circle-check"></i> &nbsp;
                                Ir al E-learning
                            </a>
                        @elseif ($event->participants->count() < $event->room->capacity)
                            <a href="#"
                                @auth
                                data-url="{{ route('home.certifications.userSelfRegister', $event) }}"
                                @endauth
                                data-send="{{ route('home.getRegisterModalContent') }}"
                                class="flex-shrink-0 btn btn-sm btn-primary px-4 py-2 event_btn_register" style="border-radius: 30px;">
                                <i class="fa-solid fa-file-signature"></i> &nbsp;
                                Incribirse
                            </a>
                        @else
                            <a href="javascript:void(0);"
                                class="flex-shrink-0 btn btn-sm btn-warning text-white px-4 py-2"
                                style="border-radius: 30px;">
                                <i class="fa-solid fa-ban"></i> &nbsp;
                                No hay vacantes disponibles
                            </a>
                        @endif

                    </div>
                </div>
                <div class="text-center p-4 pb-0">

                    <h5 class="mb-4">
                        {{ ucwords(mb_strtolower($event->description, 'UTF-8')) }}
                    </h5>
                </div>
                <div class="d-flex flex-column border-top">
                    <small
                        class="flex-fill d-flex justify-content-center align-items-center text-center border-end py-2">
                        <i class="fa fa-user-tie text-primary me-2"></i>
                        <span>

                            {{ ucwords(strtolower($event->user->full_name)) }}

                        </span>
                    </small>
                </div>
                <div class="d-flex border-top">
                    <small class="flex-fill text-center border-end py-2">
                        <i class="fa-regular text-primary fa-calendar-days me-1"></i>
                        Fecha: {{ $event->date }}
                    </small>
                    <small class="flex-fill text-center py-2">
                        <i class="fa-solid text-primary me-1 fa-user-check"></i>
                        {{ $event->room->capacity - $event->participants->count() }}
                        Vacantes disponibles
                    </small>
                </div>
            </div>
        </div>

        @if ($closeRow)
    </div>
    @endif
    @php
    $delay = $delay + 0.2;
    @endphp
    @endforeach

</div>

