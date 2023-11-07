<form method="POST" action="{{ route('home.user.register') }}" role="form" id="register-form" 
    data-validate="{{ route('register.validateDni') }}" 
    class="text-start login-form d-flex flex-column">

    @csrf

    <div class="register-principal-form-container">

        <div class="row">

            <div class="input-box my-2 col-12 col-md-6">
                <input id="dni" name="dni" type="text"
                    class="form-control @error('dni') is-invalid @enderror" required
                    autocomplete="dni" value="{{old('dni')}}" placeholder="DNI">
            </div>

            <div class="input-box my-2 col-12 col-md-6">
                <input type="text" name="name" class="form-control" placeholder="Ingrese su nombre">
            </div>

        </div>
           
        <div class="row">

            <div class="input-box my-2 col-12 col-md-6">
                <input type="text" name="paternal" class="form-control" placeholder="Ingrese su apellido paterno">
            </div>
            
            <div class="input-box my-2 col-12 col-md-6">
                <input type="text" name="maternal" class="form-control" placeholder="Ingrese su apellido materno">
            </div>

        </div>
          
    
        <div class="row">

            <div class="input-box my-2 col-12">
                <input type="email" name="email" class="form-control" placeholder="Ingrese su correo">
            </div>

        </div>
         

        <div class="row">
            
            <div class="input-box my-2 d-flex flex-column">
                <select name="company_id" class="form-control select2" id="registerCompanySelect">
                    <option></option>
                    @foreach ($companies as $company)
                    <option value="{{$company->id}}"> {{strtoupper($company->description)}} </option>
                    @endforeach
                </select>
            </div>
    
            {{-- <div class="input-box my-2 d-flex flex-column">
                <select id="registerMiningUnitsSelect" name="mining_units_ids[]" class="form-control select2" 
                        multiple="multiple"> 
                        <option></option>
                        @foreach ($miningUnits as $miningUnit)
                        <option value="{{$miningUnit->id}}"> {{strtoupper($miningUnit->description)}} </option>
                        @endforeach
                </select>
            </div> --}}
        </div>

    </div>

    <div class="mt-3 message-form d-flex align-items-center">
        <span>
            <i class="fa-regular fa-circle-question"></i>
        </span>
        <span>
            Las credenciales de inicio de sesión se enviarán a su correo electrónico luego 
            de realizar la solicitud.
        </span>
    </div>

    <div class="text-center btn-login-submit">
        <button type="submit" class="btn my-4 mb-2 ps-5 pe-4 btn-save"> 
            SOLICITAR CREDENCIALES 
            &nbsp;
            <i class="fa-solid fa-spinner fa-spin loadSpinner"></i>
        </button>
    </div>

    <div class="links-bottom-container d-flex align-items-center flex-column-reverse flex-md-row mt-3 justify-content-md-between">
        <a href="{{ route('home.index') }}">
            <i class="fa-solid fa-angles-left"></i>
            Volver a la página de inicio
        </a>

        <span>
            ¿Ya tienes una cuenta?
            <a href="{{ route('login') }}">
                Inicia sesión
            </a>
        </span>

    </div>

</form>