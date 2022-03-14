@if($locales->count() == 0)
	<div class="col text-center">
		<i class="fa fa-3x text-secondary fa-exclamation-triangle"></i>
		<br>
		<p>No hay ningun local registrado</p>
	</div>
@else
	<div class="table table-responsive">
		<table class="table table-striped">
			<tr>
				<th>Nombre</th>
				<th>Dirección</th>
				<th>Localidad</th>
				<th>Editar</th>
				<th>Eliminiar</th>
			</tr>
			@foreach($locales as $local)
				<tr>
					<td>{{$local->nombre}}</td>
					<td>{{$local->direccion}}</td>
					<td>{{$local->localidad}}</td>
					<td>
						<!-- Button trigger modal -->
						<button type="button" class="btn btn-info" data-toggle="modal" data-target="#editarlocal_{{$local->id}}">
						  <i class="fa fa-edit"></i>
						</button>

						<!-- Modal -->
						<div class="modal fade" id="editarlocal_{{$local->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
						  	<div class="modal-dialog" role="document">
						    	<div class="modal-content text-left">
						      		<div class="modal-header">
						        		<h5 class="modal-title" id="exampleModalLabel">Editar local</h5>
						        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						          			<span aria-hidden="true">&times;</span>
						        		</button>
						      		</div>
						      		<div class="modal-body">
						    			<form action="{{url('admin/local', $local->id)}}" class="form-horizontal" method="post">
						    				@csrf
						    				@method('PATCH')
						    				<div class="form-group">
						    					<label for="">Nombre</label>
						    					<input type="text" name="nombre" id="nombre" class="form-control" value="{{$local->nombre}}">
						    				</div>
						    				<div class="form-group">
						    					<label for="">Dirección</label>
						    					<input type="text" name="direccion" id="direccion" class="form-control" value="{{$local->direccion}}">
						    				</div>
						    				<div class="form-group">
						    					<label for="">Localidad</label>
						    					<input type="text" name="localidad" id="localidad" class="form-control" value="{{$local->localidad}}">
						    				</div>
						    				<hr>
						    				<div class="row">
						    					<div class="col">
						    						<button type="button" class="btn btn-secondary" data-dismiss="modal">
								    					<i class="fa fa-chevron-left"></i>
								    					Atras
								    				</button>
						    					</div>
						    					<div class="col text-right">
								        			<button class="btn btn-primary">
								        				<i class="fa fa-save"></i>
								        				Guardar
								        			</button>
						    					</div>
						    				</div>	
						    			</form>  
						      		</div>
						    	</div>
						  	</div>
						</div>
					</td>
					<td>
						@include('ayuda.eliminar', ['id' => $local->id, 'ruta' => url('admin/local', $local->id)])
					</td>
				</tr>
			@endforeach
		</table>
	</div>
@endif