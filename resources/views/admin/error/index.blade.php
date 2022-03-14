@extends('layouts.dashboard', ['menu_activo' => 'error'])

@section('contenido')
	<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Centro de incidencias</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('admin')}}">Inicio</a></li>
              <li class="breadcrumb-item active">Errores</li>
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
		                  <i class="fas fa-exclamation-circle"></i>
		                  Centro de incidencias
		                </h3>
                	</div>
                </div>
              	</div>
							<div class="card-body">
								@if($errores->count() == 0)
									<div class="row">
										<div class="col-12 text-center text-secondary">
											<i class="fa fa-3x fa-exclamation-circle"></i>
											<p>No hay incidencias registradas</p>
										</div>
									</div>
								@else
									<div class="table table-responsive">
										<table class="table table-striped">
											<tr>
												<th>#</th>
												<th class="text-center">Estado</th>
												<th class="text-center">Fecha</th>
												<th class="text-center">Ver</th>
												<th class="text-center">Eliminar</th>
											</tr>
											@foreach($errores as $error)
												<tr>
													<td>#{{$error->id}}</td>
													<td class="text-center">
		                    		@if($error->estado == "pendiente")
		                    			 <span class="badge badge-danger">Pendiente</span>
		                    		@elseif($error->estado == "tomado")
		                    			<span class="badge badge-warning">Tomado</span>
		                    		@elseif($error->estado == "resuelto")
		                    			<span class="badge badge-success">Resuelto</span>
		                    		@endif
		                    	</td>
													<td class="text-center">{{$error->created_at->format('d/m/Y H:i')}}</td>
													<td class="text-center">
														<a href="{{url('admin/error', $error->id)}}" class="btn btn-success">
															<i class="fa fa-eye"></i>
														</a>
													</td>
													<td class="text-center">
														@include('ayuda.eliminar', ['id' => $error->id, 'ruta' => url('admin/error', $error->id)])
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