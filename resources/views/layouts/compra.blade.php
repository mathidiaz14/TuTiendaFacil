<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>TuTiendaFacil.uy - Checkout</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="{{asset('css/compra2.css')}}">
	<link rel="icon" type="image/png" href="{{asset('img/favicon.png')}}">
	@yield('css')
</head>
<body>
	<div class="container-fluid p-5">
		<div class="row">
			<div class="col-12 col-md-8 info">
				<div class="col-12 text-center" style="opacity: .4;">
					<p><img src="{{asset('img/favicon.png')}}" alt="" width="30px"> Pago seguro a travez de TuTiendaFacil.uy</p>
					<hr>
				</div>
				@yield('contenido')			
			</div>	
			<div class="col-12 col-md-4 detalle">
				<div class="row">
					<div class="col-12 mb-4">
						<h5>Mi compra</h5>
					</div>
					
					@if($venta->productos != null)
						<div class="col-12">
							<div class="table">
								<table class="table">
				        			<tbody>
				        				@foreach($venta->productos as $producto)
										    <tr>
										    	<td style="position:relative;">
										    		<img src="{{producto_url_imagen($producto->id)}}" alt="" class="producto_img">
										    		<p class="cantidad_productos">{{$producto->pivot->cantidad}}</p>
										    	</td>
										    	<td class="align-middle">
													<p>
														{{$producto->nombre}}
														<br>
														<small>
															{{producto_variante($producto->pivot->variante_id)}}
														</small>
													</p>
													<p>
														<b>${{$producto->pivot->precio}}</b>
													</p>
										    	</td>
										    </tr>
										@endforeach
				        			</tbody>
									<tfoot>
										@if($venta->descuento != null)
											<tr>
												<td><p><b>Descuento</b></p></td>
												<td><p><b>$ -{{$venta->descuento}}</b></p></td>
											</tr>
										@endif
										<tr>
											<td><p><b>Total</b></p></td>
											<td><p><b>$ {{$venta->precio - $venta->descuento}}</b></p></td>
										</tr>
									</tfoot>
				        		</table>
							</div>
						</div>
					@else
						<div class="col-12">
							<p>No hay productos en el carrito de compras</p>
						</div>
					@endif
				</div>
			</div>
		</div>
	</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
	
	<script src="https://secure.mlstatic.com/sdk/javascript/v1/mercadopago.js"></script>
	<script src="https://sdk.mercadopago.com/js/v2"></script>

	@yield('js')


  	<script src="{{asset('js/csrf.js')}}"></script>
  	
</body>
</html>