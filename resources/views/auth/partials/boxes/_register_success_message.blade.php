<div class="register-success-message-container mt-5">

    <div class="icon-success-container">

        <i class="fa-regular fa-circle-check"></i>

    </div>

    <div class="message-txt text-center mt-3">
        <div>
            Su usuario se registró correctamente.
        </div>
        <div>
            Sus credenciales de inicio se enviaron al correo:  <br>
            <b> {{ $email }} </b>
        </div>
    </div>


    <div class="text-center mt-4 w-100">
        <a href="{{ route('login') }}"  class="btn btn-login-submit"> 
            INICIAR SESIÓN
        </a>
    </div>

    <div class="links-bottom-container d-flex align-items-center flex-column mt-3">

        <a href="{{ route('home.index') }}">
            <i class="fa-solid fa-angles-left"></i>
            Volver a la página de inicio
        </a>
    </div>

</div>