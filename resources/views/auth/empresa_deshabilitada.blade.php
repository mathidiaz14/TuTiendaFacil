@extends('layouts.auth')

@section('contenido')
	<div class="login100-form validate-form">
        <span class="login100-form-title p-b-43">
            <img src="{{asset('img/favicon.png')}}" alt="" width="100">
            <br>
            La empresa esta deshabilitada
            <br><br>
	        <p>Pongase en contacto con el administrador para obtener mas información.</p>
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