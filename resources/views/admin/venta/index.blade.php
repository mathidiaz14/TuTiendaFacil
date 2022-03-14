@extends('layouts.dashboard', ['menu_activo' => 'venta'])

@section('contenido')
	<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Pedidos</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('admin')}}">Inicio</a></li>
              <li class="breadcrumb-item active">Pedido</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

   <section class="content">
    	<div class="row container-fluid">
	    	<div class="col-12 col-md-4 offset-md-8">
	    		<form action="{{url('admin/venta')}}" method="get" class="form-horizontal pb-2">
	    			<div class="row">
	    				<div class="col-8">
		    				<div class="form-group">
		    					<input type="text" class="form-control" name="buscar" placeholder="Buscar pedido">
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
		                  <i class="fas fa-shopping-cart"></i>
		                  Pedidos
		                </h3>
                	</div>
                	<div class="col text-right">
                	</div>
                </div>
              	</div>
							<div class="card-body">
								@if($ventas->count() == 0)
									<div class="row">
										<div class="col-12 text-center text-secondary">
											<i class="fa fa-3x fa-shopping-cart"></i>
											<p>No hay proveedores registrados</p>
										</div>
									</div>
								@else
									<div class="table table-responsive">
										<table class="table table-striped">
											<tr>
												<th>#</th>
												<th>Cliente</th>
												<th>Tipo Entrega</th>
												<th>Estado</th>
												<th>Fecha</th>
												<th>Ver</th>
												<th>Eliminiar</th>
											</tr>
											@foreach($ventas as $venta)
												<tr>
													<td>{{$venta->codigo}}</td>
													<td>
														@if($venta->cliente_id != null)
															<a href="{{url('admin/cliente', $venta->cliente_id)}}">
																{{$venta->cliente_nombre}}
															</a>
														@else
															{{$venta->cliente_nombre}}
														@endif
													</td>
													<td>
														@if($venta->entrega == "retiro")
															Retiro en local
														@else
															Envio a domicilio
														@endif
													</td>
													<td>
														@include('ayuda.venta_estado')
													</td>
													<td>
														{{$venta->created_at->format('d/m/Y - H:i')}}
													</td>
													<td>
														<a href="{{url('admin/venta', $venta->id)}}" class="btn btn-success">
															<i class="fa fa-eye"></i>
														</a>
													</td>
													<td>
														@include('ayuda.eliminar', ['id' => $venta->id, 'ruta' => url('admin/venta', $venta->id)])
													</td>
												</tr>
											@endforeach
										</table>
									</div>
                  @include('ayuda.links', ['link' => $ventas])
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
@endsection