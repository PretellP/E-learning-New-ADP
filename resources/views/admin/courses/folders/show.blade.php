@extends('admin.common.layouts.masterpage')

@section('content')

<div class="row content">


    <div class="main-container-page">
        <div class="card page-title-container">
            <div class="card-header">
                <div class="total-width-container">
                    <h4>
                        <a href="{{route('admin.courses.index')}}">CURSOS</a>
                        <span> / <a href="{{route('admin.courses.show', $course)}}"> {{$course->description}} </a> </span>
                        @foreach ($parentFoldersCollection as $parent_folder) 
                         / <a href="{{route('admin.courses.folder.view', [$course, $parent_folder])}}"> {{$parent_folder->name}} </a>
                        @endforeach
                        <span> / {{$folder->name}}</span>

                    </h4>
                </div>
            </div>
        </div>

        <div class="card-body card z-index-2 principal-container course-show folder-view">

            <div class="folder-action-container">

                <h5 class="title-course-show">Carpeta:   <span> {{$folder->name}} </span> </h5>
              

                <div class="mt-4">

                    <div>
                        <div>
                            <h6>Editar nombre</h6>
                        </div>
                        <div>
                            <form action="{{route('folder.update', $folder)}}" method="POST">
                                @method('PATCH')
                                @csrf
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <div class="input-group">
                                            <input name='foldername' type="text" class="form-control" placeholder="Ingresa el nombre de la carpeta" required autocomplete="off" value="{{$folder->name}}">
                                            <div class="input-group-prepend">
                                                <button type="submit" class="btn btn-primary">    
                                                    <i class="fa-solid fa-arrows-rotate fa-lg"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>

                </div>

            </div>

            <div class="folder-inner-container">

                <h5 class="title-course-show mb-4"> Subcarpetas: </span> </h5>

                <div class="row">
                    <div class="col-sm-12">
                      
                        <div class="">
                            <div>
                                <h6>Añadir subcarpeta</h6>
                            </div>
                            <div>
                                
                                <form action="{{route('subfolder.create', $folder)}}" method="POST">
                                    @csrf
                                    
                                    <div class="form-group row">
                                    
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <div class="input-group subfolder-create-input">
                                                    <input name='subfoldername' type="text" class="form-control" placeholder="Ingresa el nombre de subcarpeta" required autocomplete="off">
                                                    <div class="input-group-prepend">
                                                        <button type="submit" class="btn btn-primary">    
                                                            <i class="fa-solid fa-plus fa-lg"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
    
                                </form>
    
                            </div>
                        </div>
                        
                    </div>
                </div>
    
                <div class="row mb-4">
                    <div class="col-sm-12 folder-container">
    
                        @forelse ($subfolders as $subfolder)
    
                        <a href="{{route('admin.courses.folder.view', [$course, $subfolder])}}" class="folder-link">
                            <div class="folder-card">
                                <img class="card-img-top folder-img" src="{{asset('assets/common/images/folder.png')}}" alt="Card image cap">
                                <div>
                                    <p>{{$subfolder->name}}</p>
                                </div>
                            </div>
                        </a>
    
                        @empty
    
                        <h5 class="text-center">Aún no hay subcarpetas</h5>
                            
                        @endforelse
                        
                          
                    </div>
                </div>
            </div>

            <div class="folder-inner-container">

                <h5 class="title-course-show mb-4"> Archivos: </span> </h5>


                <div class="files-section-container">
                    <div>
                        <h6> Añadir Archivo </h6>
                    </div>
                    <div>
                        
                        <form action="{{route('file.create', $folder)}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="form-group row">
                            
                                <div class="col-sm-12">
                                    <input name='filename' type="text" class="form-control" placeholder="Ingresa el nombre del archivo" required autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <input type="file" name="file" class="form-control input-file-folder" required>
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

                <div>
                    <div>
                        <h6>Lista de Archivos</h6>
                    </div>

                    <div class="table-border-style">
                        
                        <div class="table-responsive">
                            <table id="files-folder-course-table" class="table table-hover" data-url='{{route('admin.files.index', $folder)}}'>
                                <thead>
                                    <tr>
                                        <th>N°</th>
                                        <th>Nombre</th>
                                        <th>Nombre de Archivo</th>
                                        <th>Tamaño(Bytes) </th>
                                        <th>Pertenece a</th>
                                        <th>Creado el</th>
                                        <th>Actualizado el</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>

                    </div>


                </div>

            </div>

            <div class="folder-inner-container">
                <form id="delete-folder-form" method="POST" action="{{route('folder.destroy', $folder)}}">
                    @csrf @method('DELETE')
                    <button id="btn-destroy-folder" class="btn btn-danger" type="submit">
                        <i class="fa-solid fa-triangle-exclamation"></i> &nbsp; Eliminar Carpeta
                    </button>
                </form>
            </div>

        </div>

    </div>

</div>

@endsection

@section('modals')


@endsection