<button data-iziModal-close class="icon-close">x</button>
@guest
<header>
    <a href="" class="active" id="signin">Iniciar sesión</a>
    <a href="">Regístrate</a>
</header>


<section>
    <div class="error-credentials-message text-center hide">
        <i class="fa-solid fa-triangle-exclamation"></i> &nbsp;
        Las credenciales ingresadas no son válidas.
    </div>

    <div class="mb-3 text-secondary text-center">
        <i class="fa-solid fa-circle-exclamation"></i> &nbsp;
        Tienes que iniciar sesión para inscribirte
    </div>

    <form action="{{ route('login.validateAttempt') }}" id="form-modal-login" method="POST">
        @csrf
        <div class="input-group">
            <input type="text" name="dni" placeholder="Código de usuario">
        </div>
        <div class="input-group">
            <input type="password" name="password" placeholder="Contraseña">
        </div>
        <footer>
            <button data-iziModal-close>Cancelar</button>
            <button class="submit btn-save">
                Iniciar sesión
                <i class="fa-solid fa-spinner fa-spin ms-2 loadSpinner"></i>
            </button>
        </footer>
    </form>
</section>




<section class="hide">

    <div id="modal-register-form-container">

        <div class="error-credentials-message text-center hide">
            <i class="fa-solid fa-triangle-exclamation"></i> &nbsp;
            Ocurrió un error al procesar la solicitud.
        </div>

        <form action="{{ route('home.user.register') }}" method="POST" id="register-form-modal" 
            data-validate="{{ route('register.validateDni') }}">
            @csrf

            <input type="hidden" name="location" value="modal">

            <div class="row">
                <div class="col-12 col-md-6">
                    <input type="text" name="dni" placeholder="DNI">
                </div>
                <div class="col-12 col-md-6">
                    <input type="text" name="name" placeholder="Ingrese su nombre">
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-md-6">
                    <input type="text" name="paternal" placeholder="Ingrese su apellido paterno">
                </div>

                <div class="col-12 col-md-6">
                    <input type="text" name="maternal" placeholder="Ingrese su apellido materno">
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <input type="email" name="email" placeholder="Ingrese su correo">
                </div>
            </div>

            <div class="row mb-1">

                <div class="d-flex flex-column">
                    <select name="company_id" class="select2" id="registerCompanySelect">
                        <option></option>
                        @foreach ($companies as $company)
                        <option value="{{$company->id}}"> {{strtoupper($company->description)}} </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- <div class="row">
                <div class="d-flex flex-column">
                    <select id="registerMiningUnitsSelect" name="mining_units_ids[]" class="select2"
                        multiple="multiple">
                        <option></option>
                        @foreach ($miningUnits as $miningUnit)
                        <option value="{{$miningUnit->id}}"> {{strtoupper($miningUnit->description)}} </option>
                        @endforeach
                    </select>
                </div>
            </div> --}}

            <div class="my-3 message-form d-flex align-items-center">
                <span>
                    <i class="fa-regular fa-circle-question"></i>
                </span>
                <span>
                    Las credenciales de inicio de sesión se enviarán a su correo electrónico luego
                    de realizar la solicitud.
                </span>
            </div>

            <footer>
                <button data-iziModal-close>Cancelar</button>
                <button class="submit btn-save">
                    Solicitar credenciales
                    <i class="fa-solid fa-spinner fa-spin ms-2 loadSpinner"></i>
                </button>
            </footer>
        </form>

    </div>


</section>

@endguest

@auth
<form id="user-self-event-register-form" class="form-auth-register" action="" method="POST">
    <header class="auth-header-confirmation border-bottom">
        <a href="javascript:void(0);" class="active">
            <div>
                <i class="fa-solid fa-file-signature fa-lg"></i>
            </div>
            <div>
                Confirma tu inscripción ingresando tu usuario y contraseña
            </div>
        </a>
    </header>
    <section>
        <div class="error-credentials-message text-center hide">
            <i class="fa-solid fa-triangle-exclamation"></i> &nbsp;
            Las credenciales ingresadas no coinciden con tu cuenta.
        </div>

        <div class="input-group">
            <input type="text" name="dni" placeholder="Código de usuario">
        </div>
        <div class="input-group">
            <input type="password" name="password" placeholder="Contraseña">
        </div>
        <footer>
            <button data-iziModal-close>Cancelar</button>
            <button type="submit" class="submit btn-save">
                Confirmar
                <i class="fa-solid fa-spinner fa-spin ms-2 loadSpinner"></i>
            </button>
        </footer>
    </section>
</form>
@endauth