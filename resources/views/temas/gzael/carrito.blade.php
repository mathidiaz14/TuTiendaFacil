@extends(ttf_extends('master'))

@section('contenido')
    <main>
        <div class="container" style="margin-top: 60;">
            <div class="row my-5">
                <div class="col-12 text-center">
                	<h2>Carrito de compras</h2>
                	<hr>
                </div>
				@if($productos != null)
            		<div class="col-12 my-4">
	                	<div class="table table-responsive">
	                		<table class="table table-striped">
	                			<tbody>
	                				@foreach ($productos as $producto)
									    <tr>
									    	<td>
									    		<img src="{{producto_url_imagen($producto['producto']->id)}}" alt="" width="100">
									    	</td>
									    	<td class="align-middle">
												<a href="{{producto_url($producto['producto']->id)}}">	
													{{$producto['producto']->nombre}}
													@if($producto['variante'] != null)
														<br>
														<small>
															{{$producto['variante']->nombre}}
														</small>
													@endif
												</a>
									    	</td>
									    	<td class="align-middle">
								    			${{precio_producto($producto['producto']->id)}}
									    	</td>
									    	<td class="align-middle">
									    		<a href="{{eliminar_producto_carrito($producto['id'])}}" class="btn text-danger">
													<i class="fa fa-2x fa-trash"></i>
												</a>
									    	</td>
									    </tr>
									@endforeach
	                			</tbody>
								<tfoot>
									<tr>
										<td></td>
										<td><p>Total</p></td>
										<td><p><b>${{productos_precio_total($productos)}}</b></p></td>
										<td>
										</td>
									</tr>
								</tfoot>
	                		</table>
	                	</div>
                	</div>
                	<div class="col-6">
                		<a href="{{url('vaciar_carrito')}}" class="text-danger">
							<i class="fa fa-trash"></i>
							Vaciar carrito
						</a>
                	</div>
                	<div class="col-6 text-right">
                		<a href="{{comprar()}}" class="btn btn-primary">
                			Continuar con el pago
                			<i class="fa fa-chevron-right"></i>
                		</a>
                	</div>
                @else
					<div class="col-12 my-4 text-center">
						<p>No hay ningun producto en el carrito.</p>
					</div>
				@endif
            </div>
        </div>
    </main>
@endsection
