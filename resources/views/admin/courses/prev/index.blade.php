@extends('admin.layouts.admin-layout')

@section('content')

<div class="pcoded-content">
    <!-- Page-header start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Bootstrap Basic Tables</h5>
                        <p class="m-b-0">Lorem Ipsum is simply dummy text of the printing</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{route('admin.index')}}"> <i class="fa fa-home"></i> </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- Page-header end -->
    <div class="pcoded-inner-content">
        <!-- Main-body start -->
        <div class="main-body">
            <div class="page-wrapper">
                <!-- Page-body start -->
                <div class="page-body">

                    <div class="card">
                        <div class="card-header">
                            <h5>Lista de cursos</h5>
                            
                            <div class="card-header-right">
                                <ul class="list-unstyled card-option">
                                    <li><i class="fa fa fa-wrench open-card-option"></i></li>
                                    <li><i class="fa fa-window-maximize full-card"></i></li>
                                    <li><i class="fa fa-minus minimize-card"></i></li>
                                    <li><i class="fa fa-refresh reload-card"></i></li>
                                    <li><i class="fa fa-trash close-card"></i></li>
                                </ul>
                            </div>
                        </div>

                        <div class="card-block table-border-style">
                            
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Título</th>
                                            <th>Subtítulo</th>
                                            <th>Fecha</th>
                                            <th>Horas</th>
                                            <th>Hora de Inicio</th>
                                            <th>Hora Final</th>
                                            <th>Estado</th>
                                            <th>Archivos</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        @foreach($courses as $key => $course)

                                        <tr>
                                            <th> {{$key+1}} </th>
                                            <th> {{$course->description}} </th>
                                            <th> {{$course->subtitle}} </th>
                                            <th> {{$course->date}} </th>
                                            <th> {{$course->hours}} </th>
                                            <th> {{$course->time_start}} </th>
                                            <th> {{$course->time_end}} </th>
                                            <th> {{$course->active}} </th>
                                            <th> <a href="{{route('admin.course.show', $course)}}"> 
                                                    <i class="fa-regular fa-folder-open fa-xl"></i>
                                                 </a> 
                                            </th>
                                        </tr>

                                        @endforeach

                                    </tbody>
                                </table>

                               

                            </div>

            

                        </div>


                    </div>
                    <!-- Hover table card end -->

                </div>
                <!-- Page-body end -->
            </div>
        </div>
        <!-- Main-body end -->

        <div id="styleSelector">

        </div>
    </div>
</div>
    

@endsection
   

