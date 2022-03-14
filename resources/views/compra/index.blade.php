@extends('layouts.compra')

@section('contenido')
	@if($venta->empresa->configuracion->mp_estado == "conectado")
		<div class="row">
			<div class="col-12">
				@include('ayuda.alerta')
				<form action="{{url('checkout', $venta->codigo)}}" method="post" class="form-horizontal">
					@csrf
					<h5 class="mb-4"><b>Datos de contacto</b></h5>
					<div class="row">
						<div class="col-12 col-md-6">
							<div class="form-group">
								<label for="">Nombre</label>
								<input type="text" class="form-control" name="name" placeholder="Ingresa tu nombre" required="" value="{{$venta->cliente_nombre}}">
							</div>
						</div>
						<div class="col-12 col-md-6">
							<div class="form-group">
								<label for="">Apellido</label>
								<input type="text" class="form-control" name="surname" placeholder="Ingresa tu apellido" required="" value="{{$venta->cliente_apellido}}">
							</div>
						</div>
					</div>	
					<div class="row">
						<div class="col-12 col-md-6">
							<div class="form-group">
								<label for="">Email</label>
								<input type="email" class="form-control" name="email" placeholder="Ingresa un email" required="" value="{{$venta->cliente_email}}">
							</div>
						</div>
						<div class="col-12 col-md-6">
							<div class="form-group">
								<label for="">Telefono</label>
								<input type="phone" class="form-control" name="telefono" placeholder="Ingresa un telefono" value="{{$venta->cliente_telefono}}">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-12">
							<div class="form-group">
								<label for="">¿Tienes algun cupón?</label>
								<input type="text" name="cupon" class="form-control" placeholder="Ingresa un cupón">
							</div>
						</div>
					</div>
					<hr>
					<div class="form-group">
						<h4> Forma de entrega</h4>

						@if(($venta->empresa->configuracion->envio == null) and ($venta->empresa->configuracion->retiro == null)) 
							<p class="alert alert-danger">La empresa no tiene ninguna forma de entrega configurada, por lo cual no podemos continuar con la compra. Puede comunicarse con la empresa a través del correo <b>{{$venta->empresa->configuracion->email_admin}}</b>. <br>Disculpe la molestia.</p>
						@endif

						@if($venta->empresa->configuracion->envio == "on")
							<div class="form-check">
							  	<input class="form-check-input" type="radio" name="entrega" id="envio" value="envio" @if($venta->entrega == "envio") checked="" @endif>
							  	<label class="form-check-label" for="envio">
							  		<p><i class="fa fa-truck"></i> Envío a domicilio</p>
							  	</label>
							</div>
						@endif

						@if($venta->empresa->configuracion->retiro == "on")
							<div class="form-check">
							  	<input class="form-check-input" type="radio" name="entrega" id="retiro" value="retiro" @if($venta->entrega == "retiro") checked="" @endif>
								<label class="form-check-label" for="retiro">
									<p><i class="fa fa-home"></i> Retiro en local</p>
								</label>
							</div>
						@endif
					</div>
					
					@if($venta->empresa->configuracion->envio == "on")
						<div class="envio" style="@if($venta->entrega == 'envio') display: block; @else display: none; @endif">
							<div class="form-group">
								<label for="">Ciudad</label>
								<input type="text" class="form-control" name="ciudad" id="ciudad" placeholder="Ingrese la ciudad" value="{{$venta->cliente_ciudad}}">
							</div>
							<div class="row">
								<div class="col-8">
									<div class="form-group">
										<label for="">Dirección</label>
										<input type="text" class="form-control" name="direccion" id="direccion" placeholder="Ingrese la dirección" value="{{$venta->cliente_direccion}}">
									</div>
								</div>
								<div class="col-4">
									<div class="form-group">
										<label for="">Apartamento</label>
										<input type="text" class="form-control" name="apartamento" id="apartamento" placeholder="Apartamento" value="{{$venta->cliente_apartamento}}">
									</div>
								</div>
							</div>
							<div class="form-group">
								<label for="">Observación</label>
								<input type="text" class="form-control" name="observacion" id="observacion" placeholder="Ingrese la observación" value="{{$venta->cliente_observacion}}">
							</div>
						</div>
					@endif

					@if($venta->empresa->configuracion->retiro == "on")
						<div class="retiro" style="@if($venta->entrega == 'retiro') display: block; @else display: none; @endif">
							@if($venta->empresa->locales->count() == 0)
								<p class="alert alert-danger">No hay ningun local para retirar el producto</p>
							@endif
							@foreach($venta->empresa->locales as $local)
								<div class="form-check">
								  	<input class="form-check-input" type="radio" name="local" id="local_{{$local->id}}" value="{{$local->id}}" @if($loop->first) checked="" @endif>
								  	<label class="form-check-label" for="local_{{$local->id}}">
								  		<p>
								  			{{$local->nombre}}<br>
								  			<small>{{$local->localidad}}</small>
								  		</p>
								  	</label>
								</div>
							@endforeach
						</div>
					@endif
					<hr>
					<div class="row">
						<div class="col-6">
							<a href="http://{{$venta->empresa->URL}}" class="btn btn-secondary btn-block">
								<i class="fa fa-chevron-left"></i>
								Cancelar compra
							</a>
						</div>
						<div class="col-6 text-right">
							@if(($venta->empresa->configuracion->envio == null) and ($venta->empresa->configuracion->retiro == null)) 
								<button class="btn btn-info btn-block" disabled>
									<i class="fa fa-send"></i>
									Continuar con el pago
								</button>
							@else
								<button class="btn btn-info btn-block btn_pago" disabled>
									<i class="fa fa-send"></i>
									Continuar con el pago
								</button>
							@endif
						</div>
					</div>
				</form>
			</div>
		</div>
	@else
		<div class="row">
			<div class="col-12 text-center mt-5">
				<p class="alert alert-danger">La empresa no puede recibir pagos online ya que no tiene configurado MercadoPago, por lo cual no podemos continuar con la compra. Puede comunicarse con la empresa a través del correo <b>{{$venta->empresa->configuracion->email_admin}}</b>. <br>Disculpe la molestia.</p>
				<br><br>
				<a href="http://{{$venta->empresa->URL}}" class="btn btn-secondary">
					<i class="fa fa-home"></i>
					Volver al inicio
				</a>
			</div>
		</div>
	@endif
@endsection

@section('js')
	<script>
		$(document).ready(function()
		{
			$('#envio').click(function()
			{
				$('.retiro').hide();
				$('.envio').fadeIn();
				
				$('#ciudad').attr('required', true);
				$('#direccion').attr('required', true);

				$('.btn_pago').attr('disabled', false);
			});

			$('#retiro').click(function()
			{
				$('.envio').hide();
				$('.retiro').fadeIn();

				$('#ciudad').attr('required', false);
				$('#direccion').attr('required', false);
				$('.btn_pago').attr('disabled', false);
			})
		});
	</script>
@endsection
