@extends('layouts.auth')

@section('contenido')
    <form action="{{url('envio_contrasena')}}" method="post" class="login100-form validate-form">
        @csrf
         <span class="login100-form-title p-b-43">
            <img src="{{asset('img/favicon.png')}}" alt="" width="50">
            <br>
            <br>
            ¿Has olvidado tu contraseña?
            <br>
            <hr>
            <p>Danos tu cuenta de correo y te enviaremos un email para que puedas resetear tu contraseña.</p>
            <hr>
        </span>
        @include('ayuda.alerta')

        <div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
            <input class="input100" type="text" name="email" value="{{old('email')}}">
            <span class="focus-input100"></span>
            <span class="label-input100">Dirección de email</span>
        </div>
        <br>
        <hr>
        <div class="container-login100-form-btn">
            <button class="login100-form-btn" style="background: #00B36F;">
                Enviar email
            </button>
        </div>
        <div class="container-login100-form-btn mt-3">
            <a href="{{url('login')}}" class="login100-form-btn" style="border: 2px solid #00b36f;background: none;color: #00b36f;">
                Volver
            </a>
        </div>
    </form>
@endsection