@extends('layouts.compra')

@section('contenido')
	<!-- Vista creada para ver todas las opciones de pago de mercadopago -->
  	<div class="row">
  		<div class="col-12">
  			@include('ayuda.alerta')
  			<h4><b>Datos de facturación</b></h4>
  		</div>
  		<div class="col-12">
  			<div class="form-horizontal">
				<div class="row">
					<div class="col-12 col-md-6">
						<div class="form-group">
							<label for="">Nombre</label>
							<input type="text" class="form-control" value="{{$venta->cliente_nombre}}" readonly ="">
						</div>
					</div>
					<div class="col-12 col-md-6">
						<div class="form-group">
							<label for="">Apellido</label>
							<input type="text" class="form-control" value="{{$venta->cliente_apellido}}" readonly ="">
						</div>
					</div>
				</div>	
				<div class="row">
					<div class="col-12 col-md-6">
						<div class="form-group">
							<label for="">Email</label>
							<input type="email" class="form-control" value="{{$venta->cliente_email}}" readonly ="">
						</div>
					</div>
					<div class="col-12 col-md-6">
						<div class="form-group">
							<label for="">Telefono</label>
							<input type="phone" class="form-control" value="{{$venta->cliente_telefono}}" readonly ="">
						</div>
					</div>
				</div>
				<hr>
				<div class="form-group">
					@if($venta->entrega == "envio")
						<p>Envio a Domicilio</p>
						<div class="form-group">
							<label for="">Ciudad</label>
							<input type="text" class="form-control" value="{{$venta->cliente_ciudad}}" readonly="">
						</div>
						<div class="row">
							<div class="col-8">
								<div class="form-group">
									<label for="">Dirección</label>
									<input type="text" class="form-control" value="{{$venta->cliente_direccion}}" readonly="">
								</div>
							</div>
							<div class="col-4">
								<div class="form-group">
									<label for="">Apartamento</label>
									<input type="text" class="form-control"  value="{{$venta->cliente_apartamento}}" readonly="">
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="">Observación</label>
							<input type="text" class="form-control" value="{{$venta->cliente_observacion}}" readonly="">
						</div>
					@else
						<p>Retiro en local</p>
						<div class="form-check">
						  	<input class="form-check-input" type="radio" checked="" disabled="">
						  	<label class="form-check-label">
						  		<p>
						  			{{$venta->local->nombre}}<br>
						  			<small>{{$venta->local->localidad}}</small>
						  		</p>
						  	</label>
						</div>
					@endif
				</div>
			</div>
  		</div>
		<div class="col-12">
			<hr>
		</div>
		<div class="col-6">
			<a href="{{URL::Previous()}}" class="btn btn-secondary btn-block">
				<i class="fa fa-chevron-left"></i>
				Atras
			</a>
		</div>
		<div class="col-6 text-right">
			@if((env('APP_ENV') == "local") and (env('APP_DEBUG') == "true"))
				<form action="{{url('checkout/pago_exitoso')}}" method="GET">
					@csrf
					<input type="hidden" name="external_reference" value="{{$venta->codigo}}">
					<input type="hidden" name="payment_id" value="12345678">
					<button class="btn btn-primary btn-block">
						Pago de prueba
					</button>
				</form>
			@else
				<script
				  src="https://www.mercadopago.com.uy/integrations/v1/web-payment-checkout.js"
				  data-preference-id="<?php echo $preference->id; ?>"
				  data-button-label="Pagar con MercadoPago">
				</script>
			@endif
		</div>		
    </div>
@endsection