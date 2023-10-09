@extends('admin.common.layouts.masterpage')

@section('content')

<div class="row content">

    <div class="main-container-page">

        <div class="card page-title-container">
            <div class="card-header">
                <div class="total-width-container">
                    <h4>ANUNCIOS</h4>
                </div>
            </div>
        </div>


        <div class="card-body card z-index-2 principal-container">

            <div class="principal-splitted-container mt-1 mb-2">

                <div class="principal-inner-container total-width">

                    <div class="inner-title-container">
                        <div id="" class="btn-dropdown-container">
                            <h5 class="title-header-show">
                                <i class="fa-solid fa-images not-rotate"></i> &nbsp;
                                Carrusel principal
                            </h5>

                            <div class="btn-row-container">
                                <div>
                                    <span class="text-dropdown-cont">
                                        Mostrar
                                    </span>
                                    <i class="fa-solid fa-chevron-down ms-2"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="banners-list-container" class="related-dropdown-container" style="display: none;">

                        @include('admin.announcements.partials.boxes._banners_list')

                    </div>

                </div>

            </div>


            <div class="principal-splitted-container mt-4 mb-2">

                <div class="principal-inner-container total-width">


                    <div class="inner-title-container">
                        <div class="btn-dropdown-container show">
                            <h5 class="title-header-show">
                                <i class="fa-solid fa-newspaper not-rotate"></i> &nbsp;
                                Anuncios
                            </h5>

                            <div class="btn-row-container">
                                <div>
                                    <span class="text-dropdown-cont">
                                        Ocultar
                                    </span>
                                    <i class="fa-solid fa-chevron-down ms-2"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="publishings-list-container" class="related-dropdown-container table-container">

                        <div class="mb-4">
                            <button class="btn btn-primary" id="btn-register-publication-modal" data-toggle="modal"
                            data-target="#registerCardModal"
                             data-url="">
                                <i class="fa-solid fa-square-plus"></i> &nbsp; Crear publicación
                            </button>
                        </div>
            
                        <table id="publishings-table" class="table table-hover" data-url="{{ route('admin.announcements.index') }}">
                            <thead>
                                <tr>
                                    <th>N°</th>
                                    <th>Título</th>
                                    <th>Usuario</th>
                                    <th>Fecha de publicación</th>
                                    <th>Estado</th>
                                    <th>Creado el</th>
                                    <th>Actualizado el</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                        </table>

                    </div>

                </div>

            </div>


        </div>

    </div>

</div>

@endsection

@section ('modals')

@include('admin.announcements.partials.modals._banner_store')
@include('admin.announcements.partials.modals._banner_edit')

@include('admin.announcements.partials.modals._card_store')
@include('admin.announcements.partials.modals._card_edit')

@endsection