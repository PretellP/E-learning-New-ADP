@extends('aula2.common.layouts.masterpage')

@section('content')


<div class="content global-container">

    <div class="profile-view-container">

        <div class="user-profile-presentation-cont">
            <div class="img-profile-page-box">
                <img src="{{asset(Auth::user()->url_img)}}" alt="">
            </div>
            <div class="user-info-profile-page-box">
                <div class="name-info-profile-page">
                    {{strtolower(Auth::user()->name)}}
                    {{strtolower(Auth::user()->paternal)}}
                    {{strtolower(Auth::user()->maternal)}}
                </div>
                <div class="email-info-profile-page">
                    {{strtolower(Auth::user()->email)}}
                </div>
            </div>
        </div>

        <div class="card-body body-global-container profile-page-container card z-index-2 g-course-flex">

            <div class="card page-title-container sub-content">
                <div class="card-header">
                    <div class="total-width-container">
                        <h4>Información Básica</h4>
                    </div>
                </div>
            </div>

            <div class="data-profile-container">
                <div class="profile-row">
                    <div class="profile-label">Nombre completo</div>
                    <div class="profile-info"> 
                        {{Auth::user()->name}}
                        {{Auth::user()->paternal}}
                        {{Auth::user()->maternal}} 
                    </div>
                </div>
                <div class="profile-row">
                    <div class="profile-label">DNI</div>
                    <div class="profile-info">{{Auth::user()->dni}}</div>
                </div>
                <div class="profile-row">
                    <div class="profile-label">Email</div>
                    <div class="profile-info"> {{Auth::user()->email}} </div>
                </div>
                <div class="profile-row">
                    <div class="profile-label">Teléfono</div>
                    <div class="profile-info"> {{Auth::user()->telephone}} </div>
                </div>
            </div>

            <div class="card page-title-container sub-content">
                <div class="card-header">
                    <div class="total-width-container">
                        <h4>Información adicional</h4>
                    </div>
                </div>
            </div>

            <div class="data-profile-container">
                <div class="profile-row">
                    <div class="profile-label">Cargo</div>
                    <div class="profile-info"> {{Auth::user()->position}} </div>
                </div>
                <div class="profile-row">
                    <div class="profile-label">Perfil</div>
                    <div class="profile-info"> {{Auth::user()->profile_user}} </div>
                </div>
                <div class="profile-row">
                    <div class="profile-label">ECM</div>
                    <div class="profile-info"> {{Auth::user()->company->description}} </div>
                </div>
                <div class="profile-row">
                    <div class="profile-label">Unidad Minera</div>
                    <div class="profile-info"> 
                        @foreach (Auth::user()->miningUnits as $miningUnit)
                        <div>   
                            {{$miningUnit->description}}
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>


</div>



@endsection