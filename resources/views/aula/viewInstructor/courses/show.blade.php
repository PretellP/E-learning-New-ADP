@extends('aula.common.courses.layout')

@section('courseContent')

<div class="row w-100">
    <div class="col-12">
      <div class="my-4 table-container">

        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 w-100">
          <div class="bg-gradient-primary shadow-primary pt-4 pb-3">
            <h6 class="text-white text-capitalize ps-3">Eventos</h6>
          </div>
        </div>
        
        <div class="w-100 table-container-inst">
          <div class="table-responsive p-0">
            <table class="table align-items-center mb-0">

              <thead>
                <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Código</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Descipción</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tipo</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Fecha</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Activo</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Sala</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Curso</th>
                </tr>
              </thead>

              <tbody>

                @foreach($events as $event)

                    <tr>
                        <td>
                            <div class="d-flex px-2 py-1">
                                <div class="d-flex flex-column justify-content-center">
                                    <p class="text-xs text-secondary mb-0">{{ $event->id }}</p>
                                </div>
                            </div>
                        </td>
                        <td>
                            <p class="text-xs font-weight-bold mb-0"> {{$event->description}} </p>
                        </td>
                        <td class="align-middle text-center text-sm">
                            <p class="text-xs font-weight-bold mb-0"> {{ $event->type }} </p>
                        </td>
                        <td class="align-middle text-center">
                            <span class="text-secondary text-xs font-weight-bold"> {{ $event->date }} </span>
                        </td>
                        <td class="align-middle text-center">
                            <p class="text-xs font-weight-bold mb-0"> {{ $event->active }} </p>
                        </td>
                        <td class="align-middle text-center">
                            <p class="text-xs font-weight-bold mb-0"> {{ $event->room_id }} </p>
                        </td>
                        <td class="align-middle text-center">
                            <p class="text-xs font-weight-bold mb-0"> {{ $course->description }} </p>
                        </td>
                    </tr>
                @endforeach

                

                
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection

