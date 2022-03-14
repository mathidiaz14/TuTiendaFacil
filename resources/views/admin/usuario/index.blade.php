@extends('layouts.dashboard', ['menu_activo' => 'usuario'])

@section('contenido')
	<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">usuarios</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('admin')}}">Inicio</a></li>
              <li class="breadcrumb-item active">usuarios</li>
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
		                  <i class="fas fa-users"></i>
		                  Usuarios
		                </h3>
                	</div>
                	<div class="col text-right">
                		<!-- Button trigger modal -->
						<button type="button" class="btn btn-info" data-toggle="modal" data-target="#agregarusuario">
						  <i class="fa fa-plus"></i>
						  Agregar
						</button>

						<!-- Modal -->
						<div class="modal fade" id="agregarusuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
						  	<div class="modal-dialog" role="document">
						    	<div class="modal-content text-left">
						      		<div class="modal-header">
						        		<h5 class="modal-title" id="exampleModalLabel">Agregar usuario</h5>
						        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						          			<span aria-hidden="true">&times;</span>
						        		</button>
						      		</div>
						      		<div class="modal-body">
						    			<form action="{{url('admin/usuario')}}" class="form-horizontal" method="post">
						    				@csrf
						    				<div class="form-group">
						    					<label for="">Nombre</label>
						    					<input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre del usuario" required="">
						    				</div>
						    				<div class="form-group">
						    					<label for="">Email</label>
						    					<input type="email" class="form-control" name="email" placeholder="Email del usuario" required="">
						    				</div>
						    				<div class="form-group">
						    					<label for="">CI</label>
						    					<input type="text" name="ci" id="ci" class="form-control" placeholder="CI del usuario">
						    				</div>
						    				<div class="form-group">
						    					<label for="">Contraseña</label>
						    					<input type="password" name="contrasena" id="contrasena" class="form-control" required="">
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
					<div class="table table-responsive">
						<table class="table table-striped">
							<tr>
								<th>Nombre</th>
								<th>Email</th>
								<th>CI</th>
								<th>Tipo</th>
								<th>Editar</th>
								<th>Eliminiar</th>
							</tr>
							@foreach($usuarios as $usuario)
								<tr>
									<td>{{$usuario->nombre}}</td>
									<td>{{$usuario->email}}</td>
									<td>{{$usuario->ci}}</td>
									<td>{{$usuario->tipo}}</td>
									<td>
										<!-- Button trigger modal -->
										<button type="button" class="btn btn-info" data-toggle="modal" data-target="#editarusuario_{{$usuario->id}}">
										  <i class="fa fa-edit"></i>
										</button>

										<!-- Modal -->
										<div class="modal fade" id="editarusuario_{{$usuario->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
										  	<div class="modal-dialog" role="document">
										    	<div class="modal-content text-left">
										      		<div class="modal-header">
										        		<h5 class="modal-title" id="exampleModalLabel">Editar usuario</h5>
										        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										          			<span aria-hidden="true">&times;</span>
										        		</button>
										      		</div>
										      		<div class="modal-body">
										    			<form action="{{url('admin/usuario', $usuario->id)}}" class="form-horizontal" method="post">
										    				@csrf
										    				@method('PATCH')
										    				<div class="form-group">
										    					<label for="">Nombre</label>
										    					<input type="text" name="nombre" id="nombre" class="form-control" value="{{$usuario->nombre}}">
										    				</div>
										    				<div class="form-group">
										    					<label for="">Email</label>
										    					<input type="email" class="form-control" value="{{$usuario->email}}" disabled="">
										    				</div>
										    				<div class="form-group">
										    					<label for="">CI</label>
										    					<input type="text" name="ci" id="ci" class="form-control" value="{{$usuario->ci}}">
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
										@include('ayuda.eliminar', ['id' => $usuario->id, 'ruta' => url('admin/usuario', $usuario->id)])
									</td>
								</tr>
							@endforeach
						</table>
					</div>
				</div>
				<div class="card-footer bg-transparent">
				<div class="row">

				</div>
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
		$('#agregarusuario').on('shown.bs.modal', function () {
		  	$('#titulo').trigger('focus');
		});
	</script>
@endsection