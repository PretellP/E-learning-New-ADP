@extends('admin.layouts.admin-layout')

@section('content')


    <div class="pcoded-content">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="page-header-title">
                            <h5 class="m-b-10">{{$folder->name}}</h5>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{route('admin.index')}}"> <i class="fa fa-home"></i> </a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{route('admin.course.index')}}">Cursos</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{route('admin.course.show', $folder->course()->get()->first())}}">Carpetas</a>
                            </li>

                            @foreach ($parentFoldersCollection as $parent_folder) 
                                <li class="breadcrumb-item">
                                    <a href="{{route('admin.course.folder.view', [$course, $parent_folder])}}"> {{$parent_folder->name}} </a>
                                </li>     
                            @endforeach
                                
                            <li class="breadcrumb-item">
                                <a href="{{route('admin.course.folder.view', [$course, $folder])}}"> {{$folder->name}} </a>
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
                              
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Editar nombre</h5>
                                        
                                    </div>
                                    <div class="card-block">
                                        
                                        <form action="{{route('folder.update', $folder)}}" method="POST">
                                            @method('PATCH')
                                            @csrf
                                            
                                            <div class="form-group row">
                                            
                                                <div class="col-sm-12">
                                                    <input name='foldername' type="text" class="form-control" placeholder="Ingresa el nombre de la carpeta" required autocomplete="off" value="{{$folder->name}}">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <div class="col-sm-10">
                                                    <input type="submit" class="btn btn-primary waves-effect waves-light" value="Actualizar">
                                                </div>
                                            </div>

                                        </form>

                                    </div>
                                </div>
                               
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                              
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Crea una nueva sub carpeta</h5>
                                        
                                    </div>
                                    <div class="card-block">
                                        
                                        <form action="{{route('subfolder.create', $folder)}}" method="POST">
                                            @csrf
                                            
                                            <div class="form-group row">
                                            
                                                <div class="col-sm-12">
                                                    <input name='subfoldername' type="text" class="form-control" placeholder="Ingresa el nombre de la sub carpeta" required autocomplete="off">
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

                        <div class="row mb-4">
                            <div class="col-sm-12 folder-container">

                                @forelse ($subFolders as $subFolder)

                                <a href="{{route('admin.course.folder.view', [$course, $subFolder])}}" class="folder-link">
                                    <div class="card folder-card">
                                        <img class="card-img-top folder-img" src="{{asset('assets/common/images/folder.png')}}" alt="Card image cap">
                                        <div class="card-body">
                                            <p class="card-text">{{$subFolder->name}}</p>
                                        </div>
                                    </div>
                                </a>

                                @empty

                                <h4 class="text-center">Aún no hay Subcarpetas aqui </h4>
                                    
                                @endforelse
                                
                                  
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <!-- Basic Form Inputs card start -->
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Añadir Archivos</h5>
                                        
                                    </div>
                                    <div class="card-block">
                                        
                                        <form action="{{route('file.create', $folder)}}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            
                                            <div class="form-group row">
                                            
                                                <div class="col-sm-12">
                                                    <input name='filename' type="text" class="form-control" placeholder="Ingresa el nombre del archivo" required autocomplete="off">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <div class="col-sm-12">
                                                    <input type="file" name="file" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-sm-10">
                                                    <input type="submit" class="btn btn-primary waves-effect waves-light" value="Guardar">
                                                </div>
                                            </div>

                                        </form>

                                    </div>
                                </div>
                                <!-- Basic Form Inputs card end -->
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h5>Lista de Archivos</h5>
                                
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
                                                <th>Nombre</th>
                                                <th>Nombre de Archivo</th>
                                                <th>Tamaño(Bytes) </th>
                                                <th>Pertenece a</th>
                                                <th>Creado el</th>
                                                <th>Actualizado el</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                            @foreach($files as $key => $file)
    
                                            <tr>
                                                <th> {{$key+1}} </th>
                                                <th> {{$file->name}} </th>
                                                <th>
                                                    <a href="{{route('file.download', $file)}}">
                                                        {{$file->filename}} 
                                                    </a> 
                                                </th>
                                                <th> {{$file->size}} </th>
                                                <th> {{$folder->name}} </th>
                                                <th> {{$file->created_at}} </th>
                                                <th> {{$file->updated_at}} </th>
                                                <th> 
                                                    <form method="POST" action="{{route('file.destroy', $file)}}">
                                                        @csrf @method('DELETE')
                                                        <button class="btn btn-danger waves-effect waves-light" type="submit">
                                                            <i class="fa-solid fa-trash-can"></i>
                                                        </button>
                                                    </form>
                                                </th>
        
                                            </tr>
    
                                            @endforeach
    
                                        </tbody>
                                    </table>
                                </div>
    
                            </div>
    
    
                        </div>


                    </div>

                    <form method="POST" action="{{route('folder.destroy', $folder)}}">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger waves-effect waves-light" type="submit">
                            Eliminar Carpeta
                        </button>
                    </form>
                    <!-- Page body end -->
                </div>
            </div>
            <!-- Main-body end -->
            <div id="styleSelector">

            </div>
        </div>
    </div>



@endsection
   

