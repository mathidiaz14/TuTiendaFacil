<div class="row">
	@foreach($misTemas as $tema)
		@php 
			if(file_exists(resource_path('views/empresas/'.Auth::user()->empresa->id."/".$tema->pivot->carpeta."/info.xml")))
				$contenido = simplexml_load_file(resource_path('views/empresas/'.Auth::user()->empresa->id."/".$tema->pivot->carpeta."/info.xml"));
		@endphp
		<div class="col-4 p-3">
			<div class="row modal_temas">
				<div class="col-12 p-0">
					<img src="{{asset('empresas/'.Auth::user()->empresa->id.'/'.$tema->pivot->carpeta.'/screenshot.png')}}" alt="" width="100%" >
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
					@if($tema->pivot->carpeta != Auth::user()->empresa->carpeta)
    					<a href="{{url('admin/tema/activar', $tema->id)}}" class="btn btn-block btn-info">
	    					<i class="fa fa-check"></i>
	    					Activar
	    				</a>
    				@else
    					<a href="" class="btn btn-block btn-success disabled">
	    					<i class="fa fa-check"></i>
	    					Actual
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
		    					<img src="{{asset('empresas/'.Auth::user()->empresa->id.'/'.$tema->pivot->carpeta.'/screenshot.png')}}" alt="" width="100%" >
		    				</div>
		    				<div class="col-12 col-md-4">
		    					<div class="row">
		    						<div class="col-12">
		    							<h5>
				    						{{$contenido->nombre}}
				    						@if($tema->pivot->carpeta == Auth::user()->empresa->carpeta)
					    						<span class="badge bg-success">Activo</span>
					    					@endif
				    					</h5>
				    					<small>Versión: {{$contenido->version}}</small>
				    					<hr>
				    					Creado por: <a href="{{$contenido->autor_uri}}" target="_blank">{{$contenido->autor}}</a>
				    					<hr>
				    					<p>{{$contenido->descripcion}}</p>
				    					<small>Tags: {{$contenido->tags}}</small>
				    					<hr>
		    							<a href="{{url('admin/tema/descargar', $tema->id)}}" class="btn btn-block btn-info">
				    						<i class="fa fa-download"></i>
				    						Descargar
				    					</a>
		    						</div>
		    					</div>	
		    				</div>
		    			</div>
		    		</div>
		    		<div class="modal-footer">
		    			<div class="col">
	      					@if($tema->pivot->carpeta != Auth::user()->empresa->carpeta)
    							<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal_{{$tema->id}}">
									<i class="fa fa-trash"></i>
									Eliminar
								</button>

								<!-- Modal -->
								<div class="modal fade" id="deleteModal_{{$tema->id}}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true" >
									<div class="modal-dialog" role="document">
								  		<div class="modal-content">
											<div class="modal-header bg-gradient-danger">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span>
												</button>
								    		</div>
								    		<div class="modal-body text-center">
								    			<br>
								    			<p><i class="fa fa-exclamation-triangle fa-4x"></i></p>
								      			<h4>¿Desea eliminar el tema?</h4>
								      			<br>
								            	<hr>
								      			<div class="row">
								      				<div class="col">
							    						<button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">
							    							NO
							    						</button>
								      				</div>
								      				<div class="col">
								      					<form action="{{url('admin/tema',$tema->id)}}" method="POST">
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
    						@endif
		    			</div>
		    			<div class="col text-right">
		    				@if($tema->pivot->carpeta != Auth::user()->empresa->carpeta)
		    					<a href="{{url('admin/tema/activar', $tema->id)}}" class="btn btn-info">
			    					<i class="fa fa-check"></i>
			    					Activar
			    				</a>
		    				@else
		    					<a href="" class="btn btn-info disabled">
			    					<i class="fa fa-check"></i>
			    					Activar
			    				</a>
		    				@endif
		    			</div>
		    		</div>
		  		</div>
			</div>
		</div>
	@endforeach
</div>