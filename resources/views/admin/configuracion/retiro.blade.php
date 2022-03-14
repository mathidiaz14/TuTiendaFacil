<div class="row">
	<div class="col-12">
		<div class="form-group">
			<div class="row">
				<div class="col-12 col-md-9">
					<label for="">¿Realizas envíos a Domicilio?</label>
				</div>
				<div class="col-12 col-md-3">
					<div class="onoffswitch">
				    <input type="checkbox" name="envio" class="onoffswitch-checkbox" id="envio" tabindex="0" @if($configuracion->envio == "on") checked @endif>
				    <label class="onoffswitch-label" for="envio"></label>
				</div>	
				</div>
			</div>
		</div>
	</div>
	<div class="col-12">
		<div class="form-group">
			<div class="row">
				<div class="col-12 col-md-9">
					<label for="">¿Realizas entrega en local?</label>	
				</div>
				<div class="col-12 col-md-3">
					<div class="onoffswitch">
					    <input type="checkbox" name="retiro" class="onoffswitch-checkbox" id="entrega_retiro" tabindex="0" @if($configuracion->retiro == "on") checked @endif>
					    <label class="onoffswitch-label" for="entrega_retiro"></label>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-12 locales mt-2 @if($configuracion->retiro != 'on') d-none @endif">
		<hr>
		<div class="row">
			<div class="col-6">
				<h5>Locales</h5>
			</div>
			<div class="col-6 text-right my-2">
				<button type="button" class="btn btn-info" data-toggle="modal" data-target="#agregarLocal">
				  <i class="fa fa-plus"></i>
				  Agregar
				</button>

				<!-- Modal -->
				<div class="modal fade" id="agregarLocal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				  	<div class="modal-dialog" role="document">
				    	<div class="modal-content text-left">
				      		<div class="modal-header">
				        		<h5 class="modal-title" id="exampleModalLabel">Agregar local</h5>
				        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				          			<span aria-hidden="true">&times;</span>
				        		</button>
				      		</div>
				      		<div class="modal-body">
				    			<div id="formAgregarLocal" class="form-horizontal" method="post">
				    				<div class="form-group text-center" id="errorLocal" style="display:none;">
				    					<span class="alert alert-danger">
					    					Complete los campos Nombre, Dirección y Localidad
					    				</span>
				    				</div>
				    				<div class="form-group">
				    					<label for="">Nombre</label>
				    					<input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre del local">
				    				</div>
				    				<div class="form-group">
				    					<label for="">Dirección</label>
				    					<input type="text" name="direccion" id="direccion" class="form-control" placeholder="Dirección del local">
				    				</div>
				    				<div class="form-group">
				    					<label for="">Localidad</label>
				    					<input type="text" name="localidad" id="localidad" class="form-control" placeholder="¿En que localidad queda?">
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
						        			<a class="btn btn-primary text-white" id="btnFormEnviarLocal">
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
			<div class="col-12 locales_tabla">
				@include('admin.configuracion.locales')
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function()
	{
		$('#agregarLocal').on('shown.bs.modal', function () {
		  $('#nombre').trigger('focus')
		})

		$('.locales_tabla').load("{{url('admin/local')}}");

		$('#entrega_retiro').change(function()
		{
			if($(this).prop('checked'))
			{
				$('.locales').removeClass('d-none');
			}else
			{
				$('.locales').addClass('d-none');
			}
		});

		$('#btnFormEnviarLocal').click(function()
		{
			var nombre 		= $('#formAgregarLocal  #nombre').val();
			var direccion 	= $('#formAgregarLocal  #direccion').val();
			var localidad 	= $('#formAgregarLocal  #localidad').val();
			
			if((nombre == null) || (direccion == "") || (localidad == ""))
			{
				$('#errorLocal').fadeIn();
			}else
			{

				$.ajax({
			      	url: "{{url('admin/local')}}",
					type: 'POST',
		          	dataType: "JSON",
		          	data: {
						"nombre": nombre,
						"direccion": direccion,
						"localidad": localidad,
						"_token": $('meta[name="csrf-token"]').attr('content'),
		          	},success: function (data) 
		          	{
			            $('.locales_tabla').load("{{url('admin/local')}}");
						$('#formAgregarLocal #nombre').val("");
						$('#formAgregarLocal #direccion').val("");
						$('#formAgregarLocal #localidad').val("");
						$('#agregarLocal').modal('toggle');
		        	}
		        });
			}
		});
	});
</script>
