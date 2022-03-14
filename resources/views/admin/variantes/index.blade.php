<div class="form-group">
	@if($variantes->count() == 0)
		<div class="col-12 text-center text-secondary">
			<i class="fa fa-random fa-3x"></i>
			<p>No hay ninguna variante</p>
		</div>
	@else
		<div class="table table-responsive">
			<table class="table table-striped">	
				<tr>
					<th>SKU</th>
					<th>Nombre</th>
					<th>Canidad</th>
					<th>Editar</th>
					<th>Eliminar</th>
				</tr>

				@foreach($variantes as $variante)
					<tr id="variante_{{$variante->id}}">
						<td id="sku">
							{{$variante->producto->sku}} - {{$variante->sku}}
						</td>
						<td id="nombre">
							{{$variante->nombre}}
						</td>
						<td id="cantidad">
							{{$variante->cantidad}}
						</td>
						<td>
							<button type="button" class="btn btn-info" data-toggle="modal" data-target="#editModal_{{$variante->id}}">
								<i class="fa fa-edit"></i>
							</button>

							<!-- Modal -->
							<div class="modal fade" id="editModal_{{$variante->id}}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true" >
								<div class="modal-dialog modal-dialog-centered" role="document">
							  		<div class="modal-content">
										<div class="modal-header bg-gradient-info">
											<div class="col">
												<h5>Editar variante</h5>
											</div>
											<div class="col text-right">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span>
												</button>
											</div>
							    		</div>
							    		<div class="modal-body">
							    			<div class="form-group text-center" id="errorVariante_{{$variante->id}}" style="display:none;">
						    					<span class="alert alert-danger">
							    					Complete los campos obligatorios
							    				</span>
						    				</div>
						    				<div class="form-group">
						    					<label for="">SKU</label>
						    					<div class="row">
													<div class="col-2 text-right">
														<b class="sku_variable">{{$variante->producto->sku}} - </b>
													</div>
													<div class="col-10">
														<input class="form-control" id="stock_sku_{{$variante->id}}" placeholder="Codigo unico" value="{{$variante->sku}}"/>
													</div>
												</div>		
						    				</div>
						    				<div class="form-group">
						    					<label for="">Nombre *</label>
						    					<input class="form-control" id="stock_nombre_{{$variante->id}}" placeholder="Nombre variante" value="{{$variante->nombre}}" />
						    				</div>
						    				<div class="form-group">
						    					<label for="">Cantidad *</label>
						    					<input type="number" class="form-control" id="stock_cantidad_{{$variante->id}}" placeholder="Cantidad" value="{{$variante->cantidad}}"/>
						    				</div>
						    				<hr>
						    				<div class="form-group text-right">
						    					<a class="btn btn-info btn_editar_variante text-white" attr-id="{{$variante->id}}">
													<i class="fa fa-save"></i>
													Guardar
												</a>
						    				</div>
							    		</div>
							  		</div>
								</div>
							</div>
						</td>
						<td>
							<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal_{{$variante->id}}">
								<i class="fa fa-trash"></i>
							</button>

							<!-- Modal -->
							<div class="modal fade" id="deleteModal_{{$variante->id}}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true" >
								<div class="modal-dialog modal-dialog-centered" role="document">
							  		<div class="modal-content">
										<div class="modal-header bg-gradient-danger">
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
							    		</div>
							    		<div class="modal-body text-center">
							    			<p><i class="fa fa-exclamation-triangle fa-4x"></i></p>
							      			<h4>¿Desea eliminar el item?</h4>
							      			<br>
							            	<hr>
							      			<div class="row">
							      				<div class="col">
						    						<button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">
						    							NO
						    						</button>
							      				</div>
							      				<div class="col">
							      					<a class="btn btn-danger btn-block btn_eliminar_variante text-white" attr-id="{{$variante->id}}">
							      						SI
							      					</a>
							      				</div>
							      			</div>
							    		</div>
							  		</div>
								</div>
							</div>
						</td>
					</tr>
				@endforeach
			</table>
		</div>
	@endif
</div>



<script>
	@if($variantes->count() > 0)
		$('.btn_eliminar_variante').click(function()
		{
			var id = $(this).attr('attr-id');

			$.ajax({
	            url: "{{url('admin/stock')}}/"+$(this).attr('attr-id'),
				type: 'DELETE',
	            dataType: "JSON",
	            data: {
	                "id": id,
	                "_method": 'DELETE',
	                "_token": $('meta[name="csrf-token"]').attr('content'),
	            },success: function (data) {
	                $('#variante_'+id).fadeOut();
	                $('#deleteModal_{{$variante->id}}').modal('toggle');
	            },
	        });
		});


		$('.btn_editar_variante').click(function()
		{ 
			var id 			= $(this).attr('attr-id');

			var sku 		= $('#stock_sku_'+id).val();
			var nombre 		= $('#stock_nombre_'+id).val();
			var cantidad 	= $('#stock_cantidad_'+id).val();
			
			if((nombre == "") || (cantidad == ""))
			{
				$('#errorVariante_'+id).fadeIn();
			}else
			{
				$.ajax({
		      		url: "{{url('admin/stock')}}/"+id,
					type: 'PATCH',
			          dataType: "JSON",
			          data: {
			              "sku": sku,
			              "nombre": nombre,
			              "cantidad": cantidad,
			              "_token": $('meta[name="csrf-token"]').attr('content'),
			          	},success: function (data) {
							$('#variante_'+id+' > #sku').html('{{$variante->producto->sku}} - '+sku);
							$('#variante_'+id+' > #nombre').html(nombre);
							$('#variante_'+id+' > #cantidad').html(cantidad);

							$('#stock_sku_'+id).val(sku);
							$('#stock_nombre_'+id).val(nombre);
							$('#stock_cantidad_'+id).val(cantidad);
							
							$('#editModal_'+id).modal('toggle');
		        		}
			        });
			}
		});
	@endif
</script>