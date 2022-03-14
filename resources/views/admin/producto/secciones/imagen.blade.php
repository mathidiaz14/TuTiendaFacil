<div class="card">
	<div class="card-header">
		<div class="row">
			<div class="col">
				<i class="fa fa-images"></i>
				Imágenes
			</div>
			<div class="col text-right">
				<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#agregarImagenes">
					<i class="fa fa-image"></i>
					Agregar imágenes
				</button>

				<!-- Modal -->
				<div class="modal fade" id="agregarImagenes" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true" >
					<div class="modal-dialog modal-dialog-centered" role="document">
				  		<div class="modal-content">
							<div class="modal-header bg-gradient-info">
								<div class="col-10 text-left">
									<i class="fa fa-image"></i>
									Agregar imagenes
								</div>
								<div class="col-2">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
				    		</div>
				    		<div class="modal-body text-left">
			    				<form action="{{url('admin/multimedia')}}" method="post" class="dropzone" id="cargaDeImagenes"  enctype="multipart/form-data">
				        			@csrf
					        		<input type="hidden" name="producto" value="{{$producto->id}}">
								</form>
				    		</div>
				  		</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="card-body">
		<div class="form-group">
			<div id="imagenes_producto">
				{{-- Seccion donde se cargan las imagenes --}}
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function()
	{
		$('#imagenes_producto').load("{{url('admin/multimedia')}}/{{$producto->id}}");

		$('#cargaDeImagenes').dropzone({ 
		    dictDefaultMessage: "Haz click aquí o arrastra las imágenes para cargarlas",
		    maxFilesize: 30, 
		    acceptedFiles: ".jpeg,.jpg,.png,.gif",

		    success: function () 
		    {
	        	$('#imagenes_producto').load("{{url('admin/multimedia')}}/{{$producto->id}}");
		    }
		});
	});
</script>