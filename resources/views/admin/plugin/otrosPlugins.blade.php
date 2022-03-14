<div class="row">
	@foreach($plugins as $plugin)
		@php 
			$existe = Auth::user()->empresa->plugins->where('id', $plugin->id)->first();
		@endphp

		@if($existe == null)
			@php 
				if($plugin->precio > 0)
				{
					\MercadoPago\SDK::setAccessToken(env('MP_ACCESS_TOKEN'));

					$preference = new MercadoPago\Preference();

					$item                           = new MercadoPago\Item();
					$item->title                    = 'Plugin "'.$plugin->nombre.'" TuTiendaFacil.uy';
					$item->quantity                 = 1;
					$item->currency_id              = "UYU";
					$item->unit_price               = $plugin->precio;
					$preference->items              = array($item);
					$preference->external_reference = $plugin->id; 
					$preference->back_urls          = array(
					                        "success" => url('admin/plugin/pago/exitoso'),
					                        "failure" => url('admin/plugin/pago/fallido'),
					                        "pending" => url('admin/plugin/pago/pendiente')
					                    );
					$preference->auto_return        = "approved";
					$preference->save();
				}
			@endphp
			<div class="col-3 p-3">
				<div class="row modal_plugins">
					<div class="col-12 p-0">
						<img src="{{asset($plugin->imagen)}}" alt="" width="100%" >
						<div class="modal_plugins_link" type="button" data-toggle="modal" data-target="#pluginModal_{{$plugin->id}}">
							<i class="fa fa-link"></i>
						</div>
					</div>
					<div class="col-12 text-center pt-3 pb-2">
						<h5>
							{{$plugin->nombre}}
						</h5>
					</div>
				</div>
			</div>

			<div class="modal fade" id="pluginModal_{{$plugin->id}}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true" >
				<div class="modal-dialog modal-lg" role="document">
			  		<div class="modal-content">
						<div class="modal-header">
							<div class="col">
								<h5>Detalles del plugin</h5>
							</div>
							<div class="col">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
			    		</div>
			    		<div class="modal-body">
			    			<div class="row">
			    				<div class="col-12 col-md-6">
			    					<img src="{{asset($plugin->imagen)}}" alt="" width="100%" >
			    				</div>
			    				<div class="col-12 col-md-6">
			    					<div class="row">
			    						<div class="col-12">
			    							<h5>
					    						{{$plugin->nombre}}
					    					</h5>
					    					<hr>
					    					<p>{{$plugin->descripcion}}</p>
			    						</div>
			    					</div>	
			    				</div>
			    			</div>
			    		</div>
			    		<div class="modal-footer">
			    			<div class="col">
		      					
			    			</div>
			    			<div class="col text-right">
			    				@if($plugin->precio > 0)
									<script
									src="https://www.mercadopago.com.uy/integrations/v1/web-payment-checkout.js"
									data-preference-id="<?php echo $preference->id; ?>"
									data-button-label="Comprar">
									</script>
								@else
									<a href="{{url('admin/plugin/instalar', $plugin->id)}}" class="btn btn-info">
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