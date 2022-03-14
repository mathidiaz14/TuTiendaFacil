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
                		<h4 class="card-title">
		                  <i class="fas fa-shopping-bag"></i>
		                  Compras del cliente "{{$cliente->nombre}}"
		                </h4>
                	</div>
                	<div class="col text-right">
                		<a href="{{url('admin/cliente')}}" class="btn btn-secondary">
                			<i class="fa fa-chevron-left"></i>
                			Atras
                		</a>
                	</div>
                </div>
            	</div>
							<div class="card-body">
								@if($cliente->ventas->count() == 0)
									<div class="row">
										<div class="col-12 text-center text-secondary">
											<i class="fa fa-3x fa-shopping-bag"></i>
											<p>Este cliente no realizo ninguna compra</p>
										</div>
									</div>
								@else
									<div class="table table-responsive">
										<table class="table table-striped">
											<tr>
												<th>#</th>
												<th>Tipo Entrega</th>
												<th>Estado</th>
												<th>Fecha</th>
												<th>Ver</th>
												<th>Eliminiar</th>
											</tr>
											@foreach($cliente->ventas as $venta)
												<tr>
													<td>{{$venta->codigo}}</td>
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
														{{$venta->created_at->format('d/m/Y H:i')}}
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