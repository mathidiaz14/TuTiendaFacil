@extends('layouts.dashboard', ['menu_activo' => 'notificacion'])

@section('contenido')
	<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Notificaciones</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('admin')}}">Inicio</a></li>
              <li class="breadcrumb-item active">Notificaciones</li>
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
		                  <i class="fas fa-bell"></i>
		                  Notificaciones
		                </h3>
                	</div>
                </div>
              	</div>
							<div class="card-body">
								@if($notificaciones->count() == 0)
									<div class="row">
										<div class="col-12 text-center text-secondary">
											<i class="fa fa-bell fa-3x"></i>
											<p>No hay notificaciones</p>
										</div>
									</div>
								@else
									<div class="table table-responsive">
										<table class="table table-striped">
											<tr>
												<th>Titulo</th>
												<th>Contenido</th>
												<th>Fecha</th>
												<th>Link</th>
												<th>Eliminiar</th>
											</tr>
											@foreach($notificaciones->sortByDesc('created_at') as $notificacion)
												<tr>
													<td>{{$notificacion->titulo}}</td>
													<td>{{$notificacion->contenido}}</td>
													<td>{{$notificacion->created_at->format('d/m/Y H:i')}}</td>
													<td>
														<a href="{{url($notificacion->url)}}" class="btn btn-info">
															<i class="fa fa-link"></i>
														</a>
													</td>
													<td>
														@include('ayuda.eliminar', ['id' => $notificacion->id, 'ruta' => url('admin/notificacion', $notificacion->id)])
													</td>
												</tr>
											@endforeach
										</table>
									</div>
									@include('ayuda.links', ['link' => $notificaciones])
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