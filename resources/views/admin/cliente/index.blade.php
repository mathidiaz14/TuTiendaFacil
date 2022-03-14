@extends('layouts.dashboard', ['menu_activo' => 'cliente'])

@section('contenido')
	<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Clientes</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('admin')}}">Inicio</a></li>
              <li class="breadcrumb-item active">Clientes</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <section class="content">
    	<div class="row container-fluid">
	    	<div class="col-12 col-md-4 offset-md-8">
	    		<form action="{{url('admin/cliente')}}" method="get" class="form-horizontal pb-2">
	    			<div class="row">
	    				<div class="col-8">
		    				<div class="form-group">
		    					<input type="text" class="form-control" name="buscar" placeholder="Buscar cliente">
		    				</div>
	    				</div>
	    				<div class="col-4">
		    				<div class="form-group">
		    					<button class="btn btn-info mx-2 px-4 btn-block">
				    				<i class="fa fa-search"></i>
				    			</button>
		    				</div>
	    				</div>
	    			</div>
	    		</form>
	    	</div>
	    </div>
    </section>
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
		                  <i class="fas fa-users"></i>
		                  Clientes
		                </h3>
                	</div>
                	<div class="col text-right">
                		<!-- Button trigger modal -->
										<button type="button" class="btn btn-info" data-toggle="modal" data-target="#agregarCliente">
										  <i class="fa fa-plus"></i>
										  Agregar
										</button>

										<!-- Modal -->
										<div class="modal fade" id="agregarCliente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
										  	<div class="modal-dialog modal-lg" role="document">
										    	<div class="modal-content text-left">
										      		<div class="modal-header">
										        		<h5 class="modal-title" id="exampleModalLabel">Agregar cliente</h5>
										        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										          			<span aria-hidden="true">&times;</span>
										        		</button>
										      		</div>
										      		<div class="modal-body">
										    			<form action="{{url('admin/cliente')}}" class="form-horizontal" method="post">
										    				@csrf
										    				<div class="row">
									    						<div class="form-group col-6">
											    					<label for="">Nombre</label>
											    					<input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre" required="">
											    				</div>
									    						<div class="form-group col-6">
											    					<label for="">Apellido</label>
											    					<input type="text" name="apellido" id="apellido" class="form-control" placeholder="Apellido">
											    				</div>
										    				
											    				<div class="form-group col-6">
											    					<label for="">Email</label>
											    					<input type="email" name="email" id="email" class="form-control" placeholder="Email" required="">
											    				</div>

											    				<div class="form-group col-6">
											    					<label for="">Teléfono</label>
											    					<input type="text" name="telefono" id="telefono" class="form-control" placeholder="Telefono">
											    				</div>
											    				<div class="form-group col-6">
											    					<label for="">Ciudad</label>
											    					<input type="text" name="ciudad" id="ciudad" class="form-control" placeholder="Ciudad">
											    				</div>
											    				<div class="form-group col-6">
											    					<label for="">Dirección</label>
											    					<input type="text" name="direccion" id="direccion" class="form-control" placeholder="Dirección">
											    				</div>
											    				<div class="form-group col-6">
											    					<label for="">Apartamento</label>
											    					<input type="text" name="apartamento" id="apartamento" class="form-control" placeholder="Apartamento">
											    				</div>
											    				<div class="form-group col-6">
											    					<label for="">Fecha de nacimiento</label>
											    					<input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="form-control" placeholder="Fecha de nacimiento del cliente">
											    				</div>
											    				<div class="form-group col-12">
											    					<label for="">Observación</label>
											    					<textarea name="observacion" id="" class="form-control" placeholder="Observación"></textarea>
											    				</div>
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
								@if($clientes->count() == 0)
									<div class="row">
										<div class="col-12 text-center text-secondary">
											<i class="fa fa-3x fa-users"></i>
											<p>No hay ningun cliente registrado</p>
										</div>
									</div>
								@else
									<div class="table table-responsive">
										<table class="table table-striped">
											<tr>
												<th>Nombre</th>
												<th>Apellido</th>
												<th>Email</th>
												<th>Telefono</th>
												<th class="text-center">Ver</th>
												<th class="text-center">Editar</th>
												<th class="text-center">Eliminiar</th>
											</tr>
											@foreach($clientes as $cliente)
												<tr>
													<td>{{$cliente->nombre}}</td>
													<td>{{$cliente->apellido != null ? $cliente->apellido : "--"}}</td>
													<td>{{$cliente->email}}</td>
													<td>{{$cliente->telefono != null ? $cliente->telefono : "--"}}</td>
													<td class="text-center">
														<a href="{{url('admin/cliente', $cliente->id)}}" class="btn btn-success">
															<i class="fa fa-eye"></i>
														</a>
													</td>
													<td class="text-center">
														<!-- Button trigger modal -->
														<button type="button" class="btn btn-info" data-toggle="modal" data-target="#editarcliente_{{$cliente->id}}">
														  <i class="fa fa-edit"></i>
														</button>

														<!-- Modal -->
														<div class="modal fade" id="editarcliente_{{$cliente->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
														  	<div class="modal-dialog modal-lg" role="document">
														    	<div class="modal-content text-left">
														      		<div class="modal-header">
														        		<h5 class="modal-title" id="exampleModalLabel">Editar cliente</h5>
														        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														          			<span aria-hidden="true">&times;</span>
														        		</button>
														      		</div>
														      		<div class="modal-body">
														    			<form action="{{url('admin/cliente', $cliente->id)}}" class="form-horizontal" method="post">
														    				@csrf
														    				@method('PATCH')
														    				<div class="row">
														    					<div class="form-group col-6">
															    					<label for="">Nombre</label>
															    					<input type="text" name="nombre" id="nombre" class="form-control" value="{{$cliente->nombre}}" required="">
															    				</div>
															    				<div class="form-group col-6">
															    					<label for="">Apellido</label>
															    					<input type="text" name="apellido" id="apellido" class="form-control" value="{{$cliente->apellido}}">
															    				</div>
															    				<div class="form-group col-6">
															    					<label for="">Email</label>
															    					<input type="email" name="email" id="email" class="form-control" value="{{$cliente->email}}" required="">
															    				</div>

															    				<div class="form-group col-6">
															    					<label for="">Telefono</label>
															    					<input type="text" name="telefono" id="telefono" class="form-control" value="{{$cliente->telefono}}">
															    				</div>
															    				<div class="form-group col-6">
															    					<label for="">Ciudad</label>
															    					<input type="text" name="ciudad" id="ciudad" class="form-control" value="{{$cliente->ciudad}}">
															    				</div>
															    				<div class="form-group col-6">
															    					<label for="">Dirección</label>
															    					<input type="text" name="direccion" id="direccion" class="form-control" value="{{$cliente->direccion}}">
															    				</div>
															    				<div class="form-group col-6">
															    					<label for="">Apartamento</label>
															    					<input type="text" name="apartamento" id="apartamento" class="form-control" value="{{$cliente->apartamento}}">
															    				</div>
															    				<div class="form-group col-6">
															    					<label for="">Fecha de nacimiento</label>
															    					<input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="form-control" value="{{$cliente->fecha_nacimiento}}">
															    				</div>
															    				<div class="form-group col-12">
															    					<label for="">Observación</label>
															    					<textarea name="observacion" id="" class="form-control">{{$cliente->observacion}}</textarea>
															    				</div>
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
														@include('ayuda.eliminar', ['id' => $cliente->id, 'ruta' => url('admin/cliente', $cliente->id)])
													</td>
												</tr>
											@endforeach
										</table>
									</div>
									@include('ayuda.links', ['link' => $clientes])
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
		$('#agregarCliente').on('shown.bs.modal', function () {
		  	$('#nombre').trigger('focus');
		});
	</script>
@endsection