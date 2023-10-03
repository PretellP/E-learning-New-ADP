<div class="modal fade" id="registerParticipantsModal" tabindex="-1" aria-labelledby="registerParticipantsModal"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="registerParticipantsModalTitle">
                    <div class="title-header-show mt-0">
                        <i class="fa-solid fa-plus fa-xs"></i> &nbsp;
                        <span id="txt-context-element" class="text-bold">
                            Registrar participantes
                        </span>
                    </div>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"> &times; </span>
                </button>
            </div>

            <form action="{{ route('admin.events.certifications.store', $event) }}" id="register-participants-form" method="POST">
                @csrf

                <div class="modal-body">

                    <div class="group-filter-buttons-section flex-wrap">
                        <div class="form-group col-2 p-0 select-group">
                            <label class="form-label">Filtrar por empresa: &nbsp;</label>
                            <div>
                                <select name="type" class="form-control select2 select-filter-event" id="search_from_company_select">
                                    <option value=""> Todos </option>
                                    @foreach ($companies as $company)
                                    <option value="{{ $company->id }}"> {{ $company->id }} - {{ $company->description }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>

                    <table id="users-participants-table" class="table table-hover"
                            data-url="{{ route('admin.events.getUsersTable', $event) }}">
                        <thead>
                            <tr>
                                <th>Elegir</th>
                                <th>N°</th>
                                <th>DNI</th>
                                <th>Nombre</th>
                                <th>Posición</th>
                                <th>Empresa</th>
                            </tr>
                        </thead>

                    </table>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-close" data-dismiss="modal">Cerrar</button>
                    <div id="btn-store-participant-container">
                        <button class="btn btn-primary btn-save not-user-allowed" disabled> 
                            Registrar participantes 
                            <i class="fa-solid fa-spinner fa-spin loadSpinner ms-1"></i> 
                        </button>
                    </div>
                </div>

            </form>

        </div>



    </div>
</div>