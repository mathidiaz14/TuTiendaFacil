@extends('layouts.dashboard', ['menu_activo' => 'proveedor'])

@section('contenido')
	<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Productos del proveedor</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('admin')}}">Inicio</a></li>
              <li class="breadcrumb-item"><a href="{{url('admin/proveedor')}}">Proveedor</a></li>
              <li class="breadcrumb-item active">Productos</li>
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
		                  {{$proveedor->nombre}}
		                </h3>
                	</div>
                	<div class="col text-right">
                		<a href="{{url('admin/proveedor')}}" class="btn btn-secondary">
                			<i class="fa fa-chevron-left"></i>
                			Atras
                		</a>
	                </div>
              	</div>
					<div class="card-body">
						@if($productos->count() == 0)
							<div class="row">
								<div class="col-12 text-center text-secondary">
									<i class="fa fa-3x fa-exclamation-circle"></i>
									<p>No hay ningun producto en esta proveedor</p>
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