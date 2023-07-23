@extends('aula2.common.layouts.masterpage')

@section('content')

<div class="row upper-info-container">

    <div class="col-12">
        <div class="card card-upper-info">
            <div class="card-upper-info-items principal">
                Bienvenido,
            </div>

            <div class="card-upper-info-items extra">
                {{strtolower(Auth::user()->name)}},
                {{strtolower(Auth::user()->paternal)}}
                {{strtolower(Auth::user()->maternal)}}
            </div>
        </div>
    </div>

</div>



<div class="content global-container">

    <div class="card page-title-container">
        <div class="card-header">
            <div class="total-width-container">
                <h4>PERFIL</h4>
            </div>
        </div>
    </div>

    <div class="card-body body-global-container card z-index-2 g-course-flex">

        

    </div>

</div>



@endsection