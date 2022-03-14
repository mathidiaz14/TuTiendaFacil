<div class="row">
	@if($misPlugins->count() == 0)
		<div class="col-12 text-center p-5">
			<h5><i class="fa fa-plug fa-4x"></i></h5>
			<br>
			<h5>No hay ningun plugin instalado</h5>
		</div>
	@endif
	@foreach($misPlugins as $plugin)
		<div class="col-3 p-3">
			<div class="row modal_plugins">
				<div class="col-12 p-0">
					<img src="{{asset($plugin->imagen)}}" alt="" width="100%" >
					<div class="modal_plugins_link" type="button" data-toggle="modal" data-target="#pluginModal_{{$plugin->id}}">
						<i class="fa fa-link"></i>
					</div>
				</div>
				<div class="col-8 text-center pt-3 pb-2">
					<h5>
						{{$plugin->nombre}}
					</h5>
				</div>
				<div class="col-4 text-center pt-3 pb-2">
					<p>
						@if($plugin->pivot->estado == "instalado")
							<span class="badge bg-info">Instalado</span>
						@elseif($plugin->pivot->estado == "activo")
							<span class="badge bg-success">Activo</span>
						@elseif($plugin->pivot->estado == "pendiente")
							<span class="badge bg-warning">Pago pendiente</span>
						@endif
					</p>
				</div>
			</div>
		</div>

		<div class="modal fade" id="pluginModal_{{$plugin->id}}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true" >
			<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
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
	      					<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal_{{$plugin->id}}">
								<i class="fa fa-trash"></i>
								Desinstalar
							</button>

							<!-- Modal -->
							<div class="modal fade" id="deleteModal_{{$plugin->id}}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true" >
								<div class="modal-dialog modal-dialog-centered" role="document">
							  		<div class="modal-content">
										<div class="modal-header bg-gradient-danger">
											<button type="button" class="close" onClick="$('#deleteModal_{{$plugin->id}}').modal('hide');" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
							    		</div>
							    		<div class="modal-body text-center">
							    			<br>
							    			<p><i class="fa fa-exclamation-triangle fa-4x"></i></p>
							      			<h4>¿Desea eliminar el plugin?</h4>
							      			@if($plugin->precio > 0)
							      				<small class="text-red">
							      					Recuerda que este plugin es pago, si lo eliminas tendras que volver a pagar para reinstalarlo.
							      				</small>
							      			@endif
							      			<br>
							            	<hr>
							      			<div class="row">
							      				<div class="col">
						    						<button type="button" class="btn btn-secondary btn-block" 
						    							onClick="$('#deleteModal_{{$plugin->id}}').modal('hide');">
						    							NO
						    						</button>
							      				</div>
							      				<div class="col">
							      					<form action="{{url('admin/plugin',$plugin->id)}}" method="POST">
									                    @csrf
									                    <input type='hidden' name='_method' value='DELETE'>
									                    <button class="btn btn-danger btn-block">
									                        SI
									                    </button>
									                </form>
							      				</div>
							      			</div>
							    		</div>
							  		</div>
								</div>
							</div>
		    			</div>
		    			<div class="col text-right">
		    				@if($plugin->pivot->estado == "instalado")
		    					<a href="{{url('admin/plugin/activar', $plugin->id)}}" class="btn btn-info">
			    					<i class="fa fa-check"></i>
			    					Activar
			    				</a>
		    				@elseif($plugin->pivot->estado == "activo")
		    					<a href="{{url('admin/plugin/desactivar', $plugin->id)}}" class="btn btn-primary">
			    					<i class="fa fa-times"></i>
			    					Desactivar
			    				</a>
		    				@endif
		    			</div>
		    		</div>
		  		</div>
			</div>
		</div>
	@endforeach
</div>