@extends('layouts.compra')

@section('contenido')
	<div class="row">
		<div class="col-12 mb-3">
			<h4>¡Gracias por tu compra!</h4>
		</div>
		<div class="col-12" id="info">
			<div class="table table-responsive">
				<table class="table table-striped">
					<tr>
						<td>
							Numero de orden
						</td>
						<td>
							<b>#{{$venta->codigo}}</b>
						</td>
					</tr>
					<tr>
						<td>
							Nombre del comprador 
						</td>
						<td>
							<b>{{$venta->cliente_nombre}}</b>
						</td>
					</tr>
					<tr>
						<td>
							Email del comprador 
						</td>
						<td>
							<b>{{$venta->cliente_email}}</b>
						</td>
					</tr>
					@if($venta->cliente_telefono != null)
						<tr>
							<td>
								Telefono del comprador 	
							</td>
							<td>
								<b>{{$venta->cliente_telefono}}</b>
							</td>
						</tr>
					@endif
					<tr>
						<td>
							Estado
						</td>
						<td>
							@include('ayuda.venta_estado')
						</td>
					</tr>
					<tr>
						<td>
							Forma de entrega
						</td>
						<td>
							@if($venta->entrega == "retiro")
								<b>Retiro</b>
							@else
								<b>Entrega</b>
							@endif
						</td>
					</tr>
					<tr>
						@if($venta->entrega == "retiro")
							<td>
								Retiro en 
							</td>
							<td>
								<b>{{$venta->local->nombre}}</b>
							</td>
						@else
							<td>
								Entrega en 
							</td>
							<td>
								<b>{{$venta->cliente_direccion}} {{$venta->cliente_apartamento}}</b>
							</td>
						@endif
					</tr>

					@if($venta->cliente_observacion != null)
					<tr>
						<td>
							Observación
						</td>
						<td>
							<b>{{$venta->cliente_observacion}}</b>	
						</td>
					</tr>
					@endif
				</table>
			</div>
			
		</div>
		<div class="col">
			<hr>
			<div class="row pt-3">
				<div class="col">
					<a class="btn btn-info btn-block btn_print">
						<i class="fa fa-print"></i>
						Imprimir comprobante
					</a>
				</div>
				<div class="col">
					<a href="http://{{$venta->empresa->URL}}" class="btn btn-primary btn-block">
						<i class="fa fa-home"></i>
						Ir a {{$venta->empresa->nombre}}
					</a>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('js')
	<script>
		$(document).ready(function()
		{
			$('.btn_print').click(function()
			{
				var contenido= document.getElementById('info').innerHTML;
				var contenidoOriginal= document.body.innerHTML;
				document.body.innerHTML = contenido;
				window.print();
				document.body.innerHTML = contenidoOriginal;
			});
		});
	</script>	
@endsection
