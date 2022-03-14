@extends('layouts.auth')

@section('contenido')
	<div class="login100-form validate-form">
        <span class="login100-form-title p-b-43">
            <img src="{{asset('img/favicon.png')}}" alt="" width="100">
            <br><br>
            Su pago esta pendiente
            <br>
            <hr>
	        <p>Cuando el pago sea acreditado podra volver a utilizar la plataforma.</p>
            <p>Recuerda que estamos aqui por cualquier inconveniente que tengas.</p>
            <hr>
        </span>
        
        <form action="{{route('logout')}}" method="post">
            @csrf
            <div class="container-login100-form-btn">
                <button class="login100-form-btn" style="background: #00B36F;">
                    Cerrar sesion
                </button>
            </div>
        </form>
    </div>
@endsection