@extends('aula.common.layouts.masterpage')

@section('content')

<div class="content global-container">

    <div class="profile-view-container">

        <div class="user-profile-presentation-cont" id="profile-avatar-container">
            @include('aula.common.profile.partials.boxes._profile_image')
        </div>

        <div class="card-body body-global-container profile-page-container card z-index-2 principal-container">

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
                        {{$user->full_name_complete}}
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

                <div id="form-container-update-password">

                    <form action="{{ route('aula.profile.updatePassword', ["user"=> Auth::user()]) }}" method="POST"
                        id="user_password_update_form">

                        @include('aula.common.profile.partials.boxes._form_update_password')

                    </form>

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
                    <div class="profile-info"> {{$user->position ?? '-'}} </div>
                </div>
                <div class="profile-row">
                    <div class="profile-label">Perfil</div>
                    <div class="profile-info"> {{ $user->profile_user ?? '-' }} </div>
                </div>
                <div class="profile-row">
                    <div class="profile-label">ECM</div>
                    <div class="profile-info"> {{$user->company()->select('id','description')->first()->description}}
                    </div>
                </div>
                <div class="profile-row">
                    <div class="profile-label">Unidad Minera</div>
                    <div class="profile-info">
                        @foreach ($user->miningUnits()->select('mining_units.id','mining_units.description')->get() as
                        $miningUnit)
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

@section('modals')

@include('aula.common.partials.modals._edit_user_avatar')

@endsection