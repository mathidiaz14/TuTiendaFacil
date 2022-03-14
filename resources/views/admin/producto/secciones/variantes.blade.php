<div class="card">
	<div class="card-header">
		<div class="row">
			<div class="col">
				<i class="fa fa-random"></i>
				Agregar variantes de stock
				<button type="button" class="btn btn-xs btn-secondary" data-container="body" data-toggle="popover" data-placement="right" data-content="Al agregar variantes de stock, no se tendrá en cuenta la cantidad de stock colocada mas arriba. Ya que este solo se utilizara si el producto no tiene variantes.">
				  ?
				</button>
			</div>
			<div class="col text-right">
				<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#agregarVariante">
					<i class="fa fa-random"></i>
					Agregar variante
				</button>

				<!-- Modal -->
				<div class="modal fade" id="agregarVariante" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true" >
					<div class="modal-dialog modal-dialog-centered" role="document">
				  		<div class="modal-content">
							<div class="modal-header bg-gradient-info">
								<div class="col-10 text-left">
									<i class="fa fa-random"></i>
									Agregar variante
								</div>
								<div class="col-2">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
				    		</div>
				    		<div class="modal-body text-left">
			    				<div class="form-group text-center" id="errorVariante" style="display:none;">
			    					<span class="alert alert-danger">
				    					Complete los campos obligatorios
				    				</span>
			    				</div>
			    				<div class="form-group">
			    					<label for="">SKU</label>
			    					<div class="row">
											<div class="col-2 text-right">
												<b class="sku_variable">{{$producto->sku}} - </b>
											</div>
											<div class="col-10">
												<input class="form-control" id="stock_sku" placeholder="Codigo unico"/>
											</div>
										</div>		
			    				</div>
			    				<div class="form-group">
			    					<label for="">Nombre *</label>
			    					<input class="form-control" id="stock_nombre" placeholder="Nombre variante" required="" />
			    				</div>
			    				<div class="form-group">
			    					<label for="">Cantidad *</label>
			    					<input type="number" class="form-control" id="stock_cantidad" placeholder="Cantidad" required/>
			    				</div>
			    				<hr>
			    				<div class="form-group text-right">
			    					<a class="btn btn-info btn_agregar_variante text-white">
										<i class="fa fa-save"></i>
										Guardar
									</a>
			    				</div>
				    		</div>
				  		</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="card-body">
		<div class="row">
			<div id="variantes_stock" class="col">
				{{-- Seccion donde se carga la tabla de variantes --}}
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function()
	{
		$('#variantes_stock').load("{{url('admin/stock')}}/{{$producto->id}}");

		$('.btn_agregar_variante').click(function()
		{ 
			var sku 		= $('#stock_sku').val();
			var nombre 		= $('#stock_nombre').val();
			var cantidad 	= $('#stock_cantidad').val();
			
			if((nombre == "") || (cantidad == ""))
			{
				$('#errorVariante').fadeIn();
			}else
			{
				$('#errorVariante').hide();
				
				$.ajax({
		      		url: "{{url('admin/stock')}}",
					type: 'POST',
		          	dataType: "JSON",
		          	data: {
						"producto": {{$producto->id}},
						"sku": sku,
						"nombre": nombre,
						"cantidad": cantidad,
						"_token": $('meta[name="csrf-token"]').attr('content'),
		          	},success: function (data) {
			            $('#variantes_stock').load("{{url('admin/stock')}}/{{$producto->id}}");
						$('#stock_sku').val("");
						$('#stock_nombre').val("");
						$('#stock_cantidad').val("");
						$('#agregarVariante').modal('toggle');
		        	}
		        });
			}
		});
	});
</script>