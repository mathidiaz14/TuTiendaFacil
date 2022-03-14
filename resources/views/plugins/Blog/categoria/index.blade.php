@extends('layouts.dashboard', ['menu_activo' => 'blog_categoria'])

@section('contenido')
	<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('admin')}}">Inicio</a></li>
              <li class="breadcrumb-item">Blog</li>
              <li class="breadcrumb-item active">Categorías</li>
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
		                  <i class="fas fa-boxes"></i>
		                  Categorías del blog
		                </h3>
                	</div>
                	<div class="col text-right">
                		<!-- Button trigger modal -->
										<button type="button" class="btn btn-info" data-toggle="modal" data-target="#agregarCategoria">
										  <i class="fa fa-plus"></i>
										  Agregar
										</button>

										<!-- Modal -->
										<div class="modal fade" id="agregarCategoria" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
										  	<div class="modal-dialog" role="document">
										    	<div class="modal-content text-left">
										      		<div class="modal-header">
										        		<h5 class="modal-title" id="exampleModalLabel">Agregar categoría</h5>
										        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										          			<span aria-hidden="true">&times;</span>
										        		</button>
										      		</div>
										      		<div class="modal-body">
										    			<form action="{{url('admin/blog/categoria')}}" class="form-horizontal" method="post" enctype="multipart/form-data">
										    				@csrf
										    				<div class="form-group">
										    					<label for="">Titulo</label>
										    					<input type="text" name="titulo" id="titulo" class="form-control" placeholder="Nombre de la categoria" required="">
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
								@if($categorias->count() == 0)
									<div class="row">
										<div class="col-12 text-center text-secondary">
											<i class="fa fa-3x fa-boxes"></i>
											<p>No hay ninguna categoría creada.</p>
										</div>
									</div>
								@else
									<div class="table table-responsive">
										<table class="table table-striped">
											<tr>
												<th>URL</th>
												<th>Nombre</th>
												<th class="text-center">Entradas</th>
												<th class="text-center">Editar</th>
												<th class="text-center">Eliminiar</th>
											</tr>
											@foreach($categorias as $categoria)
												<tr>
													<td>
														<a href="http://{{$categoria->empresa->URL}}/blog/categoria/{{$categoria->url}}" target="_blank">{{$categoria->url}}</a>
													</td>
													<td>{{$categoria->titulo}}</td>
													<td class="text-center">
														<a href="{{url('admin/blog/categoria', $categoria->id)}}" class="btn btn-success">
															<i class="fa fa-eye"></i>
														</a>
													</td>
													<td class="text-center">
														<!-- Button trigger modal -->
														<button type="button" class="btn btn-info" data-toggle="modal" data-target="#editarCategoria_{{$categoria->id}}">
														  <i class="fa fa-edit"></i>
														</button>

														<!-- Modal -->
														<div class="modal fade" id="editarCategoria_{{$categoria->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
														  	<div class="modal-dialog" role="document">
														    	<div class="modal-content text-left">
														      		<div class="modal-header">
														        		<h5 class="modal-title" id="exampleModalLabel">Editar categoria</h5>
														        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														          			<span aria-hidden="true">&times;</span>
														        		</button>
														      		</div>
														      		<div class="modal-body">
														    			<form action="{{url('admin/blog/categoria', $categoria->id)}}" class="form-horizontal" method="post" enctype="multipart/form-data">
														    				@csrf
														    				@method('PATCH')
														    				<div class="form-group">
														    					<label for="">Nombre</label>
														    					<input type="text" name="titulo" class="form-control" value="{{$categoria->titulo}}">
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
														@include('ayuda.eliminar', ['id' => $categoria->id, 'ruta' => url('admin/blog/categoria', $categoria->id)])
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
		$('#agregarCategoria').on('shown.bs.modal', function () {
		  	$('#titulo').trigger('focus');
		});
	</script>
@endsection