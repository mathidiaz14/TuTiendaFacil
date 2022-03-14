@extends('layouts.dashboard', ['menu_activo' => 'cupon'])

@section('contenido')
	<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Cupón</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('admin')}}">Inicio</a></li>
              <li class="breadcrumb-item active">Cupón</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Main row -->
        <div class="row">
          <section class="col-lg-12">
          	@include('ayuda.alerta')
            <div class="card">
              <div class="card-header">
                <div class="row">
                	<div class="col">
                		<h3 class="card-title">
		                  <i class="fas fa-ticket-alt"></i>
		                  Cupón
		                </h3>
                	</div>
                	<div class="col text-right">
                		<!-- Button trigger modal -->
									<button type="button" class="btn btn-info" data-toggle="modal" data-target="#agregarCupon">
									  <i class="fa fa-plus"></i>
									  Agregar
									</button>

									<!-- Modal -->
									<div class="modal fade" id="agregarCupon" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
									  	<div class="modal-dialog" role="document">
									    	<div class="modal-content text-left">
									      		<div class="modal-header">
									        		<h5 class="modal-title" id="exampleModalLabel">Agregar cupón</h5>
									        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									          			<span aria-hidden="true">&times;</span>
									        		</button>
									      		</div>
									      		<div class="modal-body">
									    			<form action="{{url('admin/cupon')}}" class="form-horizontal" method="post">
									    				@csrf
							    						<div class="form-group">
									    					<label for="">Código</label>
										    				<div class="row">
										    					<div class="col-10">
											    					<input type="text" name="codigo" id="codigo" class="form-control" placeholder="Codigo del cupón" required="">
											    				</div>
										    					<div class="col-2">
										    						<a class="btn btn-info btn-block btn_cupon text-white">
										    							<i class="fa fa-dice"></i>
										    						</a>	
										    					</div>
								    						</div>
									    				</div>
									    				<div class="form-group">
									    					<label for="">Descuento %</label>
																<input type="number" max="100" min="1" class="form-control" placeholder="Porcentaje de descuento" name="descuento" required="">
									    				</div>
									    				<div class="form-group">
									    					<label for="">Cantidad</label>
															<input type="number" name="cantidad" id="cantidad" class="form-control" placeholder="Cantidad de cupónes" required=""value="1">
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
		      			</div>
    	        </div>
        	</div>
						<div class="card-body">
							@if($cupones->count() == 0)
								<div class="row">
									<div class="col-12 text-center text-secondary">
										<i class="fa fa-3x fa-ticket-alt"></i>
										<p>No hay ninguna cupón creada.</p>
									</div>
								</div>
							@else
								<div class="table table-responsive">
									<table class="table table-striped">
										<tr>
											<th>Código</th>
											<th class="text-center">Descuento</th>
											<th class="text-center">Cantidad</th>
											<th class="text-center">Estado</th>
											<th class="text-center">Cambiar</th>
											<th class="text-center">Editar</th>
											<th class="text-center">Eliminiar</th>
										</tr>
										@foreach($cupones as $cupon)
											<tr>
												<td>
													{{$cupon->codigo}}
												</td>
												<td class="text-center">
													{{$cupon->descuento}}%
												</td>
												<td class="text-center">
													{{$cupon->cantidad}}
												</td>
												<td class="text-center">
													@if($cupon->estado == "activo") 
														<span class="badge bg-success p-2">Activo</span>
													@else 
														<span class="badge bg-danger p-2">Inactivo</span>
													@endif
												</td>
												<td class="text-center">
													@if($cupon->estado == "activo")
														<a href="{{url('admin/cupon/cambiar', $cupon->id)}}" class="btn btn-danger">
															Desactivar
														</a>
													@else
														<a href="{{url('admin/cupon/cambiar', $cupon->id)}}" class="btn btn-success">
															Activar
														</a>
													@endif
												</td>
												<td class="text-center">
													<!-- Button trigger modal -->
													<button type="button" class="btn btn-info" data-toggle="modal" data-target="#editarCupon_{{$cupon->id}}">
													  <i class="fa fa-edit"></i>
													</button>

													<!-- Modal -->
													<div class="modal fade" id="editarCupon_{{$cupon->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
													  	<div class="modal-dialog" role="document">
													    	<div class="modal-content text-left">
												      		<div class="modal-header">
												        		<h5 class="modal-title" id="exampleModalLabel">Editar cupón</h5>
												        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												          			<span aria-hidden="true">&times;</span>
												        		</button>
												      		</div>
													      		<div class="modal-body">
														    			<form action="{{url('admin/cupon', $cupon->id)}}" class="form-horizontal" method="post">
													    				@csrf
													    				@method('PATCH')
											    						<div class="form-group">
													    					<label for="">Código</label>
														    				<div class="row">
														    					<div class="col-10">
															    					<input type="text" name="codigo" class="form-control" placeholder="Codigo del cupón" required="" value="{{$cupon->codigo}}">
															    				</div>
														    					<div class="col-2">
														    						<a class="btn btn-info btn-block btn_cupon text-white">
														    							<i class="fa fa-dice"></i>
														    						</a>	
														    					</div>
												    						</div>
													    				</div>
													    				<div class="form-group">
													    					<label for="">Descuento %</label>
																			<input type="number" max="100" min="1" class="form-control" placeholder="Porcentaje de descuento" name="descuento" value="{{$cupon->descuento}}" required="">
																			
													    				</div>
													    				<div class="form-group">
													    					<label for="">Cantidad de cupones</label>
																			<input type="number" name="cantidad" id="cantidad" class="form-control" placeholder="Cantidad de cupónes" value="{{$cupon->cantidad}}" required="">
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
												<td class="text-center">
													@include('ayuda.eliminar', ['id' => $cupon->id, 'ruta' => url('admin/cupon', $cupon->id)])
												</td>
											</tr>
										@endforeach
									</table>
								</div>
							@endif
						</div>
          </div>
        </section>
      </div>
    </div>
  </section>
</div>
@endsection

@section('scripts')
	<script>
		$('#agregarCupon').on('shown.bs.modal', function () {
		  	$('#codigo').trigger('focus');
		});
		
		$('.btn_cupon').click(function()
		{
			$('#codigo').val(Math.random().toString(36).substring(3));
		});
	</script>
@endsection