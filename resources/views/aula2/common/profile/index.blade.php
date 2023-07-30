@extends('aula2.common.layouts.masterpage')

@section('content')


<div class="content global-container">

    <div class="profile-view-container">

        <div class="user-profile-presentation-cont">
            <div class="img-profile-page-box">
                <img src="{{asset($user->url_img)}}" alt="">
            </div>
            <div class="user-info-profile-page-box">
                <div class="name-info-profile-page">
                    {{strtolower($user->name)}}
                    {{strtolower($user->paternal)}}
                    {{strtolower($user->maternal)}}
                </div>
                <div class="email-info-profile-page">
                    {{strtolower($user->email)}}
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
                        {{$user->name}}
                        {{$user->paternal}}
                        {{$user->maternal}} 
                    </div>
                </div>
                <div class="profile-row">
                    <div class="profile-label">DNI</div>
                    <div class="profile-info">{{$user->dni}}</div>
                </div>
                <div class="profile-row">
                    <div class="profile-label">Email</div>
                    <div class="profile-info"> {{$user->email}} </div>
                </div>
                <div class="profile-row">
                    <div class="profile-label">Teléfono</div>
                    <div class="profile-info"> {{$user->telephone}} </div>
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
                    <div class="profile-info"> {{$user->position}} </div>
                </div>
                <div class="profile-row">
                    <div class="profile-label">Perfil</div>
                    <div class="profile-info"> {{$user->profile_user}} </div>
                </div>
                <div class="profile-row">
                    <div class="profile-label">ECM</div>
                    <div class="profile-info"> {{$user->company()->select('id','description')->first()->description}} </div>
                </div>
                <div class="profile-row">
                    <div class="profile-label">Unidad Minera</div>
                    <div class="profile-info"> 
                        @foreach ($user->miningUnits()->select('mining_units.id','mining_units.description')->get() as $miningUnit)
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