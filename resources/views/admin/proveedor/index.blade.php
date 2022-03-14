@extends('layouts.dashboard', ['menu_activo' => 'proveedor'])

@section('contenido')
	<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Proveedores</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('admin')}}">Inicio</a></li>
              <li class="breadcrumb-item active">Proveedores</li>
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
		                  <i class="fas fa-truck"></i>
		                  Proveedores
		                </h3>
                	</div>
                	<div class="col text-right">
                		<!-- Button trigger modal -->
										<button type="button" class="btn btn-info" data-toggle="modal" data-target="#agregarProveedor">
										  <i class="fa fa-plus"></i>
										  Agregar
										</button>

										<!-- Modal -->
										<div class="modal fade" id="agregarProveedor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
										  	<div class="modal-dialog" role="document">
										    	<div class="modal-content text-left">
										      		<div class="modal-header">
										        		<h5 class="modal-title" id="exampleModalLabel">Agregar proveedor</h5>
										        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										          			<span aria-hidden="true">&times;</span>
										        		</button>
										      		</div>
										      		<div class="modal-body">
										    			<form action="{{url('admin/proveedor')}}" class="form-horizontal" method="post">
										    				@csrf
										    				<div class="form-group">
										    					<label for="">Nombre</label>
										    					<input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre del proveedor" required="">
										    				</div>
										    				<div class="form-group">
										    					<label for="">RUT</label>
										    					<input type="text" name="rut" id="rut" class="form-control" placeholder="RUT del proveedor">
										    				</div>
										    				<div class="form-group">
										    					<label for="">Email</label>
										    					<input type="email" name="email" id="email" class="form-control" placeholder="Email del proveedor" required="">
										    				</div>
										    				<div class="row">
											    				<div class="form-group col-6">
											    					<label for="">Teléfono</label>
											    					<input type="text" name="telefono" id="telefono" class="form-control" placeholder="Teléfono del proveedor">
											    				</div>
											    				<div class="form-group col-6">
											    					<label for="">Dirección</label>
											    					<input type="text" name="direccion" id="direccion" class="form-control" placeholder="Dirección del proveedor">
											    				</div>
										    				</div>
										    				<div class="form-group">
										    					<label for="">Observación</label>
										    					<textarea name="observacion" id="" class="form-control" placeholder="Observación de la categoria"></textarea>
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
								@if($proveedores->count() == 0)
									<div class="row">
										<div class="col-12 text-center text-secondary">
											<i class="fa fa-3x fa-truck"></i>
											<p>No hay proveedores registrados</p>
										</div>
									</div>
								@else
									<div class="table table-responsive">
										<table class="table table-striped">
											<tr>
												<th>Nombre</th>
												<th>RUT</th>
												<th>Teléfono</th>
												<th>Email</th>
												<th>Dirección</th>
												<th>Observación</th>
												<th class="text-center">Productos</th>
												<th class="text-center">Editar</th>
												<th class="text-center">Eliminiar</th>
											</tr>
											@foreach($proveedores as $proveedor)
												<tr>
													<td>{{$proveedor->nombre}}</td>
													<td>{{$proveedor->rut}}</td>
													<td>{{$proveedor->telefono}}</td>
													<td>{{$proveedor->email}}</td>
													<td>{{$proveedor->direccion}}</td>
													<td>{{$proveedor->observacion}}</td>
													<td class="text-center">
														<a href="{{url('admin/proveedor', $proveedor->id)}}" class="btn btn-success">
															<i class="fa fa-eye"></i>
														</a>
													</td>
													<td class="text-center">
														<!-- Button trigger modal -->
														<button type="button" class="btn btn-info" data-toggle="modal" data-target="#editarProveedor_{{$proveedor->id}}">
														  <i class="fa fa-edit"></i>
														</button>

														<!-- Modal -->
														<div class="modal fade" id="editarProveedor_{{$proveedor->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
														  	<div class="modal-dialog" role="document">
														    	<div class="modal-content text-left">
														      		<div class="modal-header">
														        		<h5 class="modal-title" id="exampleModalLabel">Editar proveedor</h5>
														        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														          			<span aria-hidden="true">&times;</span>
														        		</button>
														      		</div>
														      		<div class="modal-body">
														    			<form action="{{url('admin/proveedor', $proveedor->id)}}" class="form-horizontal" method="post">
														    				@csrf
														    				@method('PATCH')
														    				<div class="form-group">
														    					<label for="">Nombre</label>
														    					<input type="text" name="nombre" id="nombre" class="form-control" value="{{$proveedor->nombre}}" required="">
														    				</div>
														    				<div class="form-group">
														    					<label for="">RUT</label>
														    					<input type="text" name="rut" id="rut" class="form-control" value="{{$proveedor->rut}}">
														    				</div>
														    				<div class="form-group">
														    					<label for="">Email</label>
														    					<input type="email" name="email" id="email" class="form-control" placeholder="Email del proveedor" value="{{$proveedor->email}}">
														    				</div>
														    				<div class="row">
															    				<div class="form-group col-6">
															    					<label for="">Teléfono</label>
															    					<input type="text" name="telefono" id="telefono" class="form-control" placeholder="Telefono del proveedor" value="{{$proveedor->telefono}}">
															    				</div>
															    				<div class="form-group col-6">
															    					<label for="">Dirección</label>
															    					<input type="text" name="direccion" id="direccion" class="form-control" placeholder="Dirección del proveedor" value="{{$proveedor->direccion}}">
															    				</div>
														    				</div>
														    				<div class="form-group">
														    					<label for="">Observación</label>
														    					<textarea name="observacion" id="" class="form-control">{{$proveedor->observacion}}</textarea>
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
														@include('ayuda.eliminar', ['id' => $proveedor->id, 'ruta' => url('admin/proveedor', $proveedor->id)])
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
		$('#agregarProveedor').on('shown.bs.modal', function () {
		  	$('#nombre').trigger('focus');
		});
	</script>
@endsection