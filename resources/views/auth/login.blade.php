@extends('layouts.auth')

@section('contenido')
    <form action="{{url('login')}}" method="post" class="login100-form validate-form">
        @csrf
        <input type="hidden" name="redirect" value="{{$request->redirect}}">
        <span class="login100-form-title p-b-43">
            <img src="{{asset('img/favicon.png')}}" alt="" width="50">
            <br>
            <br>
            ¡Que bueno verte otra vez!
            <br>
        </span>
        @include('ayuda.alerta')
        <div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
            <input class="input100" type="text" name="email" value="{{old('email')}}" autofocus="">
            <span class="focus-input100"></span>
            <span class="label-input100">Dirección de email</span>
        </div>
        
        
        <div class="wrap-input100 validate-input" data-validate="Password is required">
            <input class="input100" type="password" name="password">
            <span class="focus-input100"></span>
            <span class="label-input100">Contraseña</span>
        </div>

        <div class="flex-sb-m w-full p-t-3 p-b-32">
            <div class="contact100-form-checkbox">
                <input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
                <label class="label-checkbox100" for="ckb1">
                    Recuerdame
                </label>
            </div>

            <div>
                <a href="{{url('envio_contrasena')}}" class="txt1">
                    ¿Olvidaste tu contraseña?
                </a>
            </div>
        </div>


            <hr>
        <div class="container-login100-form-btn">
            <button class="login100-form-btn" style="background: #00B36F;">
                Iniciar Sesión
            </button>
        </div>
        <div class="container-login100-form-btn mt-3">
            <a href="{{url('registrarse')}}" class="login100-form-btn" style="border: 2px solid #00b36f;background: none;color: #00b36f;">
                Registrate
            </a>
        </div>
    </form>
@endsection