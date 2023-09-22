@extends('admin.common.layouts.masterpage')

@section('content')

<div class="row content">


    <div class="main-container-page">
        <div class="card page-title-container">
            <div class="card-header">
                <div class="total-width-container">
                    <h4>
                        <a href="{{route('admin.courses.index')}}">CURSOS</a>
                        <span> / {{$course->description}} </span>
                    </h4>
                </div>
            </div>
        </div>

        <div class="card-body card z-index-2 principal-container course-show">

            <div class="info-course-container">

                <h5 class="title-course-show">Información General: </h5>

                <div class="mt-4">

                    <div class="upper-container-info mb-4">

                        <div class="inner-container-info right-subcontainer-info">

                            <span class="title-img-course-prev">Previsualización de imagen:</span>
                            <div class="img-course-prev-container">
                                <img src="{{asset('storage/'.verifyImage($course->url_img))}}" alt="">
                            </div>

                        </div>

                    </div>

                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>N°</th>
                                <th>Nombre</th>
                                <th>Subtítulo</th>
                                <th>Fecha</th>
                                <th>Hora Inicio</th>
                                <th>Hora Fin</th>
                                <th>Estado</th>
                            </tr>
                        </thead>

                        <tbody>
                            <td> {{$course->id}} </td>
                            <td> {{$course->description}} </td>
                            <td> {{$course->subtitle}} </td>
                            <td> {{$course->date}} </td>
                            <td> {{getTimeforHummans($course->time_start)}} </td>
                            <td> {{getTimeforHummans($course->time_end)}} </td>
                            <td> 
                                @php
                                    $status = $course->active == 'S' ? 'active' : 'inactive';
                                    $txtBtn = $status == 'active' ? 'Activo' : 'Inactivo';
                                @endphp    

                                <span class="status {{$status}}"> {{$txtBtn}} </span>
                            </td>
                        </tbody>
                    </table>
                   
                </div>



            </div>

            <div class="info-content-course-container ">

                <h5 class="title-course-show">Contenido: </h5>

                <div class="mt-4">
                    <div class="page-body">

                        <div class="row">

                            <div class="col-sm-12">
                                <div>
                                    <div>
                                        <h6>Crear Carpeta </h6>
                                    </div>
                                    <div class="card-block">
                                        <form action="{{route('folder.create', $course)}}" method="POST">
                                            @csrf
                                            <div class="form-group row">
                                                <div class="col-sm-12">
                                                    <input name='name' type="text" class="form-control"
                                                        placeholder="Ingresa el nombre de la carpeta" required
                                                        autocomplete="off">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <div class="col-sm-10">
                                                    <input type="submit"
                                                        class="btn btn-primary" value="Crear">
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="row">

                            <div class="col-sm-12 folder-container">

                                @forelse ($folders as $folder)

                                <a href="{{route('admin.courses.folder.view', $folder)}}" class="folder-link">
                                    <div class="folder-card">
                                        <img class="folder-img"
                                            src="{{asset('assets/common/images/folder.png')}}" alt="Card image cap">
                                        <div>
                                            <p class="card-text">{{$folder->name}}</p>
                                        </div>
                                    </div>
                                </a>

                                @empty

                                <h5 class="text-center">Aún no has creado carpetas </h5>

                                @endforelse


                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection

@section('modals')


@endsection