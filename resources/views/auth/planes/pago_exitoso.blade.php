@extends('layouts.auth')

@section('contenido')
	<div class="login100-form validate-form">
        <span class="login100-form-title p-b-43">
            <img src="{{asset('img/favicon.png')}}" alt="" width="100">
            <br>
            Su pago se realizo exitosamente
            <br><br>
	        <p>¡Ya puedes disfrutar de nuestra plataforma!</p>
	        <p>Tu dominio se esta creando en este momento, demorara unas horas en estar disponible, nosotros te avisaremos cuendo este funcionando. </p>
            <br>
            <p>Recuerda que estamos aqui por cualquier inconveniente que tengas.</p>
        </span>

        <div class="container-login100-form-btn">
            <a href="{{url('admin')}}" class="login100-form-btn" style="background: #00B36F;">
                Continuar
            </a>
        </div>
    </div>
@endsection