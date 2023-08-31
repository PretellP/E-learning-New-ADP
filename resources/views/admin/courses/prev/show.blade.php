@extends('admin.layouts.admin-layout')

@section('content')


    <div class="pcoded-content">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="page-header-title">
                            <h5 class="m-b-10">{{$course->description}}</h5>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{route('admin.index')}}"> <i class="fa fa-home"></i> </a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{route('admin.course.index')}}">Cursos</a>
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

                    <!-- Page body start -->
                    <div class="page-body">
                           
                        <div class="row">
                            <div class="col-sm-12">
                                <!-- Basic Form Inputs card start -->
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Crea una nueva carpeta</h5>
                                        
                                    </div>
                                    <div class="card-block">
                                        
                                        <form action="{{route('folder.create', $course)}}" method="POST">
                                            @csrf
                                            
                                            <div class="form-group row">
                                            
                                                <div class="col-sm-12">
                                                    <input name='foldername' type="text" class="form-control" placeholder="Ingresa el nombre de la carpeta" required autocomplete="off">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <div class="col-sm-10">
                                                    <input type="submit" class="btn btn-primary waves-effect waves-light" value="Crear">
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

                                <a href="{{route('admin.course.folder.view', [$course, $folder])}}" class="folder-link">
                                    <div class="card folder-card">
                                        <img class="card-img-top folder-img" src="{{asset('assets/common/images/folder.png')}}" alt="Card image cap">
                                        <div class="card-body">
                                            <p class="card-text">{{$folder->name}}</p>
                                        </div>
                                    </div>
                                </a>

                                @empty

                                <h4 class="text-center">Aún no hay carpetas aqui </h4>
                                    
                                @endforelse
                                
                                  
                            </div>
                        </div>

                    </div>
                    <!-- Page body end -->
                </div>
            </div>
            <!-- Main-body end -->
            <div id="styleSelector">

            </div>
        </div>
    </div>



@endsection
   

