@extends('layouts.root', ['menu_activo' => 'error'])

@section('contenido')
  	<div class="content-wrapper">
    
    	<div class="content-header">
      		<div class="container-fluid">
        		<div class="row mb-2">
          			<div class="col-sm-6">
            			<h1 class="m-0 text-dark">Errores reportados</h1>
          			</div>
          			<div class="col-sm-6">
            			<ol class="breadcrumb float-sm-right">
              				<li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
              				<li class="breadcrumb-item active">Error</li>
            			</ol>
          			</div>
        		</div>
      		</div>
		</div>
    
    	<section class="content">
      		@include('ayuda.alerta')
      		<div class="container-fluid">
          		<div class="row">
            		<section class="col-lg-12">
              			<div class="card">
                			<div class="card-header border-1">
                  				<h3 class="card-title">
                    				Errores reportados
                  				</h3>
                			</div>
                			<div class="card-body">
                  				<div class="row">
                    				<div class="table table-responsive">
                      					<table class="table table-striped">
                        					<tbody>
                          						<tr>
						                            <th>#</th>
						                            <th>Empresa</th>
						                            <th>Usuario</th>
						                            <th>Pantalla</th>
						                            <th>Estado</th>
                                        <th>Fecha</th>
						                            <th>Acción</th>
						                            <th>Ver</th>
						                            <th>Eliminar</th>
                          						</tr>
                          						@foreach($errores as $error)
                            						<tr>
						                            	<td>{{$error->id}}</td>
						                            	<td>{{$error->usuario->empresa->nombre}}</td>
						                            	<td>{{$error->usuario->nombre}}</td>
						                            	<td>{{$error->pantalla}}</td>
					                              	<td>
					                              		@if($error->estado == "pendiente")
					                              			 <span class="badge badge-danger">Pendiente</span>
					                              		@elseif($error->estado == "tomado")
					                              			<span class="badge badge-warning">Tomado</span>
					                              		@elseif($error->estado == "resuelto")
					                              			<span class="badge badge-success">Resuelto</span>
					                              		@endif
					                              	</td>
                                          <td>{{$error->created_at->format('d/m/y H:i')}}</td>
					                              	<td>
                														@if($error->estado == "pendiente")
                                              <a href="{{url('root/error/tomar',$error->id)}}" class="btn btn-block btn-warning">
                                                <i class="fa fa-check-circle"></i>
                                                Tomar
                                              </a>
                                            @elseif($error->estado == "tomado")
                                              <a href="{{url('root/error/resolver',$error->id)}}" class="btn btn-block btn-primary">
                                                <i class="fa fa-check-circle"></i>
                                                Resolver
                                              </a>
                                            @elseif($error->estado == "resuelto")
                                              <a href="{{url('root/error/reabrir',$error->id)}}" class="btn btn-block btn-info">
                                                <i class="fa fa-check-circle"></i>
                                                Reabrir
                                              </a>
                                            @endif

              														</td>
              														<td>
              															<a href="{{url('root/error',$error->id)}}" class="btn btn-success">
              																<i class="fa fa-eye"></i>
              															</a>
              														</td>
              														<td>
              															@include('ayuda.eliminar', ['id' => $error->id, 'ruta' => url('root/error', $error->id)])
              														</td>
                            						</tr>
                      							@endforeach
                        					</tbody>
                      					</table>
                    				</div>
                  				</div>
                  				<div class="row text-center">
                    				{{$errores->links()}}
                  				</div>
                			</div>
              			</div>
            		</section>
          		</div>
      		</div>
    	</section>
  	</div>
@endsection