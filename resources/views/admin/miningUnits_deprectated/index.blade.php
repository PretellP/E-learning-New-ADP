@extends('admin.common.layouts.masterpage')

@section('content')

<div class="row content">


    <div class="main-container-page">
        <div class="card page-title-container">
            <div class="card-header">
                <div class="total-width-container">
                    <h4>Unidades Mineras</h4>
                </div>
            </div>
        </div>

        <div class="card-body card z-index-2 principal-container">

            <div class="mb-4">
                <button class="btn btn-primary" id="btn-register-user-modal" 
                    data-toggle="modal" data-target="#RegisterMiningUnitModal">
                    <i class="fa-solid fa-square-plus"></i> &nbsp; Registrar
                </button>
            </div>

            <table id="mining-units-table" class="table table-hover" data-url="{{route('admin.miningUnits.index')}}">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Descripción</th>
                        <th>Titular</th>
                        <th>Distrito</th>
                        <th>Provincia</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>
            
        </div>

    </div>

</div>

@endsection

@section('modals')

<div class="modal fade" id="RegisterMiningUnitModal" tabindex="-1" aria-labelledby="RegisterMiningUnitModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="RegisterMiningUnitModalLabel">
                    <div class="section-title mt-0">
                        <i class="fa-solid fa-square-plus"></i> &nbsp;
                        Registrar Unidad Minera
                    </div>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{route('admin.miningUnits.store')}}" id="registerMiningUnitForm" method="POST">
                @csrf

                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-12">
                            <label>Descripción *</label>
                            <input type="text" name="description" class="form-control description"
                                    placeholder="Ingrese el nombre de la unidad minera">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>Titular (opcional)</label>
                            <input type="text" name="owner" class="form-control" 
                            placeholder="Ingrese titular">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>Distrito (opcional)</label>
                            <input type="text" name="district" class="form-control" 
                            placeholder="Ingrese distrito">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>Provincia (opcional)</label>
                            <input type="text" name="Province" class="form-control" 
                            placeholder="Ingrese distrito">
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-close" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary btn-save">
                        Guardar
                        <i class="fa-solid fa-spinner fa-spin loadSpinner ms-1"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editMiningUnitModal" tabindex="-1" aria-labelledby="editMiningUnitModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="editMiningUnitModalLabel">
                    <div class="section-title mt-0">
                        <i class="fa-solid fa-pen-to-square"></i> &nbsp;
                        Editar Unidad Minera
                    </div>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="" id="editMiningUnitForm" method="POST">
                @csrf

                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-12">
                            <label>Descripción *</label>
                            <input type="text" name="description" class="form-control description"
                                    placeholder="Ingrese el nombre de la unidad minera">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>Titular (opcional)</label>
                            <input type="text" name="owner" class="form-control" 
                            placeholder="Ingrese titular">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>Distrito (opcional)</label>
                            <input type="text" name="district" class="form-control" 
                            placeholder="Ingrese distrito">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>Provincia (opcional)</label>
                            <input type="text" name="Province" class="form-control" 
                            placeholder="Ingrese distrito">
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-close" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary btn-save">
                        Guardar
                        <i class="fa-solid fa-spinner fa-spin loadSpinner ms-1"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection