@extends('admin.common.layouts.masterpage')

@section('content')

<div class="row content">

    <div class="main-container-page">
        <div class="card page-title-container">
            <div class="card-header">
                <div class="total-width-container">
                    <h4>Certificados</h4>
                </div>
            </div>
        </div>

        <div class="card-body card z-index-2 principal-container">

            <div class="group-filter-buttons-section">
                <div class="form-group date-range-container">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <a href="javascript:;" id="daterange-btn-certifications"
                                class="btn btn-primary icon-left btn-icon pt-2">
                                <i class="fas fa-calendar"></i>
                                Elegir Fecha
                            </a>
                        </div>
                        <input type="text" name="date-range" class="form-control date-range-input"
                            id="date-range-input-certifications" disabled>
                    </div>
                </div>
            </div>

            <div class="group-filter-buttons-section flex-wrap">

                <div class="form-group col-2 p-0 select-group">
                    <label class="form-label">Filtrar por empresa: &nbsp;</label>
                    <div>
                        <select name="company" class="form-control select2 select-filter-certification" id="search_from_company_select">
                            <option value=""> Todos </option>
                            @foreach ($companies as $company)
                            <option value="{{ $company->id }}"> {{ $company->id }} - {{$company->description}} </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group col-2 p-0 select-group">
                    <label class="form-label">Filtrar por curso: &nbsp;</label>
                    <div>
                        <select name="course" class="form-control select2 select-filter-certification" id="search_from_course_select">
                            <option value=""> Todos </option>
                            @foreach ($courses as $course)
                            <option value="{{ $course->id }}"> {{ $course->id }} - {{$course->description}} </option>
                            @endforeach
                        </select>
                    </div>
                </div>

            </div>


            <table id="certifications-index-table" class="table table-hover"
                data-url="{{ route('admin.certifications.index') }}">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>DNI</th>
                        <th>Apellidos y nombres</th>
                        <th>Empresa</th>
                        <th>Curso</th>
                        <th>Fecha</th>
                        <th>Nota</th>
                        <th>Examen</th>
                        <th>Certificado</th>
                    </tr>
                </thead>
            </table>


            <a href="">
                
            </a>

        </div>

    </div>

</div>

@endsection