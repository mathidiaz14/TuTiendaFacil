@extends('layouts.auth')

@section('contenido')
    <form action="{{url('resetear/contrasena')}}" method="post" class="login100-form validate-form" style="padding-top: 100px;">
        @csrf
        <input type="hidden" name="user" value="{{$user->id}}">
         <span class="login100-form-title p-b-43">
            <img src="{{asset('img/favicon.png')}}" alt="" width="50">
            <br>
            <br>
            Hola {{$user->nombre}}, aqui puedes cambiar tu contraseña.
            <br>
            <hr>
            <p>La contraseña debe tener al menos 8 caracteres, mayúsculas y números.</p>
            <hr>
        </span>
        @include('ayuda.alerta')

        <div class="wrap-input100 validate-input" data-validate = "">
            <input class="input100" type="password" name="password" autofocus="">
            <span class="focus-input100"></span>
            <span class="label-input100">Contraseña</span>
        </div>
        <div class="wrap-input100 validate-input" data-validate = "">
            <input class="input100" type="password" name="re_password">
            <span class="focus-input100"></span>
            <span class="label-input100">Repetir Contraseña</span>
        </div>
        <br>
        <hr>
        <div class="container-login100-form-btn">
            <button class="login100-form-btn" style="background: #00B36F;">
                Cambiar contraseña
            </button>
        </div>
    </form>
@endsection