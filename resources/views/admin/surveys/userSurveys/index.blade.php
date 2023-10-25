@extends('admin.common.layouts.masterpage')

@section('content')

<div class="row content">


    <div class="main-container-page">
        <div class="card page-title-container">
            <div class="card-header">
                <div class="total-width-container">
                    <h4>Encuestas: Reporte de encuestados</h4>
                </div>
            </div>
        </div>

        <div class="card-body card z-index-2 principal-container">

            <div class="group-filter-buttons-section">
                <div class="form-group date-range-container">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <a href="javascript:;" id="daterange-btn-surveys"
                                class="btn btn-primary icon-left btn-icon pt-2">
                                <i class="fas fa-calendar"></i>
                                Elegir Fecha
                            </a>
                        </div>
                        <input type="text" name="date-range" class="form-control date-range-input"
                            id="date-range-input-surveys" disabled>
                    </div>
                </div>
            </div>

            <form action="{{ route('admin.download.excel.user.surveys') }}" id="form-survey-report-export" method="GET">
                <input type="hidden" name="from_date" value="">
                <input type="hidden" name="end_date" value="">

                <div class="mb-4">
                    <button type="submit" class="btn btn-success" id="btn-export-user-surveys">
                        <i class="fa-solid fa-download"></i> &nbsp; Descargar Excel
                        <i class="fa-solid fa-spinner fa-spin loadSpinner ms-1"></i>
                    </button>
                </div>
            </form>


            <table id="general-user-surveys-table" class="table table-hover" 
                data-url="{{ route('admin.surveys.reports.index') }}">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>DNI</th>
                        <th>A. Paterno</th>
                        <th>A. Materno</th>
                        <th>Nombres</th>
                        <th>Empresa</th>
                        <th>Encuesta</th>
                        <th>Fecha de finalización</th>
                        <th>Instructor</th>
                        <th>Curso</th>
                    </tr>
                </thead>
            </table>

        </div>

    </div>

</div>

@endsection
