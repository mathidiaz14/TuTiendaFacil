@extends('layouts.auth')

@section('contenido')
	<div class="login100-form validate-form">
        <span class="login100-form-title p-b-43">
            <img src="{{asset('img/favicon.png')}}" alt="" width="100">
            <br><br>
            Su pago se realizo exitosamente
            <br>
            <hr>
	        <p>¡Ya puedes volver a disfrutar de nuestra plataforma!</p>
            <p>Recuerda que estamos aqui por cualquier inconveniente que tengas.</p>
            <hr>
        </span>

        <div class="container-login100-form-btn">
            <a href="{{url('admin')}}" class="login100-form-btn" style="background: #00B36F;">
                Continuar
            </a>
        </div>
    </div>
@endsection