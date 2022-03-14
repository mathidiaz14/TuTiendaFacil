<div class="row">
	@if($multimedia->count() == 0)
		<div class="col-12 text-center text-secondary">
			<i class="fa fa-3x fa-images"></i>
			<p>El producto no tiene imagenes</p>
		</div>
	@else
		<div class="col-12 mb-2">
			<small><i class="fa fa-star text-warning"></i> Seleccione la estrella si quiere colocar la imagen como principal del producto</small>
		</div>
		@foreach($multimedia as $imagen)
			<div class="col-6 col-md-3 col-lg-2 contenedor_imagen_producto" id="imagen_{{$imagen->id}}">
				<img src="{{asset($imagen->url)}}" alt="" width="100%" class="imagen_producto">

				<a class="boton_eliminar_imagen" data-toggle="modal" data-target="#deleteModal_{{$imagen->id}}">
					<i class="fa fa-trash"></i>
				</a>

				<!-- Modal -->
				<div class="modal fade deleteModal" id="deleteModal_{{$imagen->id}}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true" >
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
				      					<a class="boton_eliminar btn btn-danger btn-block text-white" attr-id="{{$imagen->id}}">
											SI
										</a>					
				      				</div>
				      			</div>
				    		</div>
				  		</div>
					</div>
				</div>
				<a class="boton_imagen_principal @if($imagen->tipo == 'principal')seleccionada @endif" attr-id="{{$imagen->id}}">
					<i class="fa fa-star"></i>
				</a>
			</div>	
		@endforeach	
	@endif
</div>

<script>
	$(document).ready(function()
	{
		$('.boton_eliminar').click(function()
		{ 
			var id = $(this).attr('attr-id');
			$.ajax({
	            url: "{{url('admin/multimedia')}}/"+$(this).attr('attr-id'),
				type: 'DELETE',
	            dataType: "JSON",
	            data: {
	                "id": id,
	                "_method": 'DELETE',
	                "_token": $('meta[name="csrf-token"]').attr('content'),
	            },success: function (data) {
	                $('#imagen_'+id).fadeOut();
	                $('#deleteModal_'+id).modal('toggle');
	            },
	            error: function (data) {
	              	console.log(data)  
	            }
	        });
		});

		$('.boton_imagen_principal').click(function()
		{
			var id = $(this).attr('attr-id');
			
			$.ajax({
	            url: "{{url('admin/principal/multimedia')}}",
				type: 'POST',
	            dataType: "JSON",
	            data: {
	                "id": id,
	                "_token": $('meta[name="csrf-token"]').attr('content'),
	            },success: function (data) {
	                $('.boton_imagen_principal').removeClass('seleccionada');
	                $('#imagen_'+id+' > .boton_imagen_principal').addClass('seleccionada');
	            }
	        });	
		});
	});
</script>