@extends('layouts.auth')

@section('contenido')
    <form action="{{ url('registrarse') }}" method="post" class="login100-form" style="padding-top: 100px;">
        @csrf
        <span class="login100-form-title p-b-43">
            <img src="{{asset('img/favicon.png')}}" alt="" width="50">
            <br>
            ¡Regístrate ya!
        </span>
        @include('ayuda.alerta')
        
        <div class="wrap-input100 validate-input">
            <input class="input100" type="text" name="name" value="{{old('name')}}">
            <span class="focus-input100"></span>
            <span class="label-input100">Tu nombre</span>
        </div>

        <div class="wrap-input100 validate-input">
            <input class="input100" type="text" name="email" value="{{old('email')}}">
            <span class="focus-input100"></span>
            <span class="label-input100">Tu email</span>
        </div>

        <div class="wrap-input100 validate-input">
            <input class="input100" type="password" name="password">
            <span class="focus-input100"></span>
            <span class="label-input100">Contraseña</span>
        </div>

        <div class="wrap-input100 validate-input">
            <input class="input100" type="password" name="repassword">
            <span class="focus-input100"></span>
            <span class="label-input100">Repite la contraseña</span>
        </div>
        <hr>
        <div class="wrap-input100 validate-input">
            <select name="plan" class="input100 plan" required="" style="border:none;">
                <option></option>
                <option value="plan1">Plan emprendedor - ${{opcion('plan1')}}</option>
                <option value="plan2">Plan avanzado - ${{opcion('plan2')}}</option>
                <option value="plan3">Plan profesional - ${{opcion('plan3')}}</option>
            </select>
            <span class="focus-input100"></span>
            <span class="label-input100">Elije un plan</span>
        </div>
        <hr>
        <div class="container-login100-form-btn">
            <button class="login100-form-btn" style="background: #00B36F;">
                Comienza ya
            </button>
        </div>
        <div class="container-login100-form-btn mt-2">
            <a href="{{URL::Previous()}}" class="login100-form-btn" style="border: 2px solid #00b36f;background: none;color: #00b36f;">
                Volver
            </a>
        </div>
    </form>
@endsection
