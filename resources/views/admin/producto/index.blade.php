@extends('layouts.dashboard', ['menu_activo' => 'producto'])

@section('contenido')
	<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Productos</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('admin')}}">Inicio</a></li>
              <li class="breadcrumb-item active">Productos</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
     <section class="content">
    	<div class="row container-fluid">
	    	<div class="col-12 col-md-4 offset-md-8">
	    		<form action="{{url('admin/producto')}}" method="get" class="form-horizontal pb-2">
	    			<div class="row">
	    				<div class="col-8">
		    				<div class="form-group">
		    					<input type="text" class="form-control" name="buscar" placeholder="Buscar producto">
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
		                  <i class="fas fa-archive"></i>
		                  Productos
		                </h3>
                	</div>
                	<div class="col text-right">
                		<!-- Button trigger modal -->
										<button type="button" class="btn btn-info" data-toggle="modal" data-target="#agregarProducto">
										  <i class="fa fa-plus"></i>
										  Agregar producto
										</button>

										<!-- Modal -->
										<div class="modal fade" id="agregarProducto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
									  	<div class="modal-dialog" role="document">
									    	<div class="modal-content text-left">
									      		<div class="modal-header">
									        		<h5 class="modal-title" id="exampleModalLabel">Crear producto</h5>
									        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									          			<span aria-hidden="true">&times;</span>
									        		</button>
									      		</div>
									      		<div class="modal-body">
									    			<form action="{{url('admin/producto/create')}}" class="form-horizontal" method="get">
									    				@csrf
									    				<div class="form-group">
									    					<label for="">Nombre</label>
									    					<input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre" required="">
									    				</div>
									    				<div class="form-group">
									    					<label for="">Precio</label>
									    					<input type="number" name="precio" id="precio" class="form-control" placeholder="Precio" required="">
									    				</div>	
									    				<hr>
									    				<div class="form-group">
									    					<div class="row">
									    						<div class="col">
									    							<button type="button" class="btn btn-secondary" data-dismiss="modal">
												    					<i class="fa fa-chevron-left"></i>
												    					Atras
												    				</button>
									    						</div>
									    						<div class="col text-right">
											    					<button class="btn btn-info">
											    						<i class="fa fa-plus"></i>
											    						Crear producto
											    					</button>
									    						</div>
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
									@if($productos->count() == 0)
										<div class="row">
											<div class="col-12 text-center text-secondary">
												<i class="fa fa-3x fa-archive"></i>
												<p>No hay ningun producto registrado</p>
											</div>
										</div>
									@else
										<div class="table table-responsive">
											<table class="table table-striped">
												<tr>
													<th>SKU</th>
													<th>Imagen</th>
													<th>Nombre</th>
													<th>Precio</th>
													<th>Categoría</th>
													<th>Stock</th>
													<th>Estado</th>
													<th>Ver</th>
													<th>Editar</th>
													<th>Eliminiar</th>
												</tr>
												@foreach($productos as $producto)
													<tr>
														<td class="align-middle">
															{{$producto->sku != null ? $producto->sku : "--" }}
														</td>
														<td class="align-middle">
															<img src="{{producto_url_imagen($producto->id)}}" width="100px">
														</td>
														<td class="align-middle">
															<b>{{$producto->nombre}}</b>
														</td>
														<td class="align-middle">
															$ {{producto_precio($producto->id)}}
														</td>
														<td class="align-middle">
															{{$producto->categoria_id != null ? $producto->categoria->titulo : "--"}}
														</td>
														<td class="align-middle">
															{{producto_stock_cantidad($producto->id) != null ? producto_stock_cantidad($producto->id) : "--"}}
														</td>
														<td class="align-middle">
															{{$producto->estado == "borrador" ? "Borrador" : "Publicado"}}
														</td>
														<td class="align-middle">
															@if($producto->estado == "borrador")
																<a class="btn btn-success disabled">
																	<i class="fa fa-eye"></i>
																</a>
															@else
																<a href="http://{{$producto->empresa->URL}}/{{$producto->url}}" class="btn btn-success" target="_blank">
																	<i class="fa fa-eye"></i>
																</a>
															@endif
														</td>
														<td class="align-middle">
															<a href="{{route('producto.edit', $producto->id)}}" class="btn btn-info">
																<i class="fa fa-edit"></i>
															</a>
														</td>
														<td class="align-middle">
															@include('ayuda.eliminar', ['id' => $producto->id, 'ruta' => url('admin/producto', $producto->id)])
														</td>
													</tr>
												@endforeach
											</table>
										</div>
										@include('ayuda.links', ['link' => $productos])
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
		$('#agregarProducto').on('shown.bs.modal', function () {
		  	$('#nombre').trigger('focus');
		});
	</script>
@endsection