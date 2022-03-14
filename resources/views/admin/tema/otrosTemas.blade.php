<div class="row">
	@foreach($otrosTemas as $tema)
		@php 
			$existe = Auth::user()->empresa->temas->where('id', $tema->id)->first();
		@endphp
		@if($existe == null)
			@php 
				if(file_exists(resource_path('views/temas/'.$tema->carpeta."/info.xml")))
				{
					$contenido = simplexml_load_file(resource_path('views/temas/'.$tema->carpeta.'/info.xml'));
				}

				if($tema->precio > 0)
				{
					\MercadoPago\SDK::setAccessToken(env('MP_ACCESS_TOKEN'));

					$preference = new MercadoPago\Preference();

					$item                           = new MercadoPago\Item();
					$item->title                    = 'Tema "'.$tema->nombre.'" TuTiendaFacil.uy';
					$item->quantity                 = 1;
					$item->currency_id              = "UYU";
					$item->unit_price               = $tema->precio;
					$preference->items              = array($item);
					$preference->external_reference = $tema->id; 
					$preference->back_urls          = array(
					                        "success" => url('admin/tema/pago/exitoso'),
					                        "failure" => url('admin/tema/pago/fallido'),
					                        "pending" => url('admin/tema/pago/pendiente')
					                    );
					$preference->auto_return        = "approved";
					$preference->save();
				}
			@endphp

			<div class="col-4 p-3">
				<div class="row modal_temas">
					<div class="col-12 p-0">
						<img src="{{asset('temas/'.$tema->carpeta.'/screenshot.png')}}" alt="" width="100%" >
						<div class="modal_temas_link" type="button" data-toggle="modal" data-target="#temaModal_{{$tema->id}}">
							<i class="fa fa-link"></i>
						</div>
					</div>
					<div class="col-8 text-center pt-3">
						<h5>
							{{$contenido->nombre}}
						</h5>
					</div>
					<div class="col-4 py-2">
						@if($tema->precio > 0)
							<script
							src="https://www.mercadopago.com.uy/integrations/v1/web-payment-checkout.js"
							data-preference-id="<?php echo $preference->id; ?>"
							data-button-label="Comprar">
							</script>
						@else
							<a href="{{url('admin/tema/instalar', $tema->id)}}" class="btn btn-block btn-info">
								<i class="fa fa-download"></i>
								Instalar
							</a>
						@endif
					</div>
				</div>
			</div>

			<div class="modal fade" id="temaModal_{{$tema->id}}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true" >
				<div class="modal-dialog modal-xl" role="document">
			  		<div class="modal-content">
						<div class="modal-header">
							<div class="col">
								<h5>Detalles del tema</h5>
							</div>
							<div class="col">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
			    		</div>
			    		<div class="modal-body">
			    			<div class="row">
			    				<div class="col-12 col-md-8">
			    					<img src="{{asset('temas/'.$tema->carpeta.'/screenshot.png')}}" width="100%" >
			    				</div>
			    				<div class="col-12 col-md-4">
			    					<h5>
			    						{{$contenido->nombre}}
			    					</h5>
			    					<small>Versión: {{$contenido->version}}</small>
			    					<hr>
			    					Creado por: <a href="{{$contenido->autor_uri}}" target="_blank">{{$contenido->autor}}</a>
			    					<hr>
			    					<p>{{$contenido->descripcion}}</p>
			    					<small>Tags: {{$contenido->tags}}</small>	
			    				</div>
			    			</div>
			    		</div>
			    		<div class="modal-footer">
			    			<div class="col text-right">
								@if($tema->precio > 0)
									<script
									src="https://www.mercadopago.com.uy/integrations/v1/web-payment-checkout.js"
									data-preference-id="<?php echo $preference->id; ?>"
									data-button-label="Comprar">
									</script>
								@else
									<a href="{{url('admin/tema/instalar', $tema->id)}}" class="btn btn-info">
										<i class="fa fa-download"></i>
										Instalar
									</a>
								@endif
			    			</div>
			    		</div>
			  		</div>
				</div>
			</div>
		@endif
	@endforeach
</div>