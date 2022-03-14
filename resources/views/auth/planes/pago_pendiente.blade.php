@extends('layouts.auth')

@section('contenido')
	<div class="login100-form validate-form">
        <span class="login100-form-title p-b-43">
            <img src="{{asset('img/favicon.png')}}" alt="" width="100">
            <br>
            Su pago esta pendiente
            <br>
            <hr>
            <br>
	        <p>Cuando el pago sea acreditado podra empezar a utilizar la plataforma.</p>
            <br>
            <p>Recuerda que estamos aqui por cualquier inconveniente que tengas.</p>
        </span>

        <form action="{{route('logout')}}" method="post">
            @csrf
            <div class="container-login100-form-btn">
                <hr>
                <button class="login100-form-btn" style="background: #00B36F;">
                    Cerrar sesion
                </button>
            </div>
        </form>
    </div>
@endsection