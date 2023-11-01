@extends('admin.common.layouts.masterpage')

@section('content')

<div class="row content">


    <div class="main-container-page">
        <div class="card page-title-container">
            <div class="card-header">
                <div class="total-width-container">
                    <h4>USUARIOS</h4>
                </div>
            </div>
        </div>

        <div class="card-body card z-index-2 principal-container">

            <div class="mb-4">
                <button class="btn btn-primary" id="btn-register-user-modal" data-url='{{route('admin.users.registerGetCompanies')}}'>
                    <i class="fa-solid fa-user-plus"></i> &nbsp; Registrar
                </button>

                <button class="btn btn-primary ms-4" id="btn-register-user-modal" data-toggle='modal' data-target="#RegisterUserMassiveModal">
                    <i class="fa-solid fa-file-import"></i> &nbsp; Registro masivo
                </button>
            </div>

            <table id="users-table" class="table table-hover" data-url="{{route('admin.users.index')}}">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>DNI</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Empresa</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>

        </div>



    </div>

</div>

@endsection

@section('modals')

@include('admin.users.partials.modals._register_user')
@include('admin.users.partials.modals._edit_user')
@include('admin.users.partials.modals._register_massive')

@endsection