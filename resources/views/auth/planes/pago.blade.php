@extends('layouts.auth')

@section('css')
	<style>
		.mercadopago-button
		{
			display: -webkit-box!important;
			display: -webkit-flex!important;
			display: -moz-box!important;
			display: -ms-flexbox!important;
			display: flex!important;
			justify-content: center!important;
			align-items: center!important;
			padding: 0 20px!important;
			width: 100%!important;
			height: 50px!important;
			border-radius: 10px!important;
			background: #00b36f!important;

			font-family: Montserrat-Bold!important;
			font-size: 12px!important;
			color: #fff!important;
			line-height: 1.2!important;
			text-transform: uppercase!important;
			letter-spacing: 1px!important;

			-webkit-transition: all 0.4s!important;
			-o-transition: all 0.4s!important;
			-moz-transition: all 0.4s!important;
			transition: all 0.4s!important;
		}

		.mercadopago-button:hover
		{
			background: #333333!important;
		}
	</style>	
@endsection

@section('contenido')
    <div class="login100-form" style="padding-top: 50px;">
		<span class="login100-form-title p-b-43">
		    <img src="{{asset('img/favicon.png')}}" alt="" width="50">
		    <hr>
          	<h5 style="color:#9d9d9d;">Datos de facturación</h5>
		    <hr>
		</span>

		@include('ayuda.alerta')

 			<div class="wrap-input100">
	            <input class="input100 has-val" readonly="" type="text" value="{{$empresa['nombre']}}" disabled>
	            <span class="focus-input100"></span>
	            <span class="label-input100">Nombre</span>
	        </div>
	        <div class="wrap-input100">
	            <input class="input100 has-val" readonly="" type="text" value="{{$empresa['URL']}}" disabled>
	            <span class="focus-input100"></span>
	            <span class="label-input100">URL</span>
	        </div>
	        <div class="wrap-input100">
	            <input class="input100 has-val" readonly="" type="text" value="{{$empresa['titulo']}}" disabled>
	            <span class="focus-input100"></span>
	            <span class="label-input100">Titulo de la web</span>
	        </div>
	        <div class="wrap-input100">
	            <input class="input100 has-val" readonly="" type="text" value="{{$empresa['descripcion']}}" disabled>
	            <span class="focus-input100"></span>
	            <span class="label-input100">Descripción corta</span>
	        </div>
	        <div class="wrap-input100">
	            <input class="input100 has-val" readonly="" type="text" value="{{@if($empresa['plan'] == 'plan1') Emprendedor @elseif($empresa['plan'] == 'plan2') Avanzado @else Profesional @endif}}" disabled>
	            <span class="focus-input100"></span>
	            <span class="label-input100">Plan</span>
	        </div>
	        <div class="wrap-input100">
	            <input class="input100 has-val" readonly="" type="text" value="{{$empresa['expira']->format('d/m/Y H:i')}}" disabled>
	            <span class="focus-input100"></span>
	            <span class="label-input100">Expira</span>
	        </div>
	        <div class="wrap-input100">
	            <input class="input100 has-val" readonly="" type="text" value="{{$usuario['email']}}" disabled="">
	            <span class="focus-input100"></span>
	            <span class="label-input100">Email</span>
	        </div>
	        <hr>
	        <br>
	     	<div class="col-12">
	     		<div class="container-login100-form-btn">
	     			<script
						src="https://www.mercadopago.com.uy/integrations/v1/web-payment-checkout.js"
						data-preference-id="<?php echo $preference->id; ?>"
						data-button-label="Pagar">
					</script>
	     		</div>	 	
	     		<br>
	     		<div class="container-login100-form-btn">
		            <a href="{{url('/')}}" class="login100-form-btn" style="border: 2px solid #00b36f;background: none;color: #00b36f;">
		                Cancelar
		            </a>
		        </div>
	       	</div>
 	</div>
@endsection
