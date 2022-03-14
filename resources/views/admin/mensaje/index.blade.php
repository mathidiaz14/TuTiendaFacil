@extends('layouts.dashboard', ['menu_activo' => 'mensaje'])

@section('contenido')
	<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Mensajes</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('admin')}}">Inicio</a></li>
              <li class="breadcrumb-item active">Mensajes</li>
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
		                  <i class="fas fa-envelope"></i>
		                  Mensajes
		                </h3>
                	</div>
                	<div class="col text-right">
                		
                	</div>
                </div>
              	</div>
							<div class="card-body">
								@if($mensajes->count() == 0)
									<div class="row">
										<div class="col-12 text-center text-secondary">
											<i class="fa fa-3x fa-envelope"></i>
											<p>No hay ningun mensaje</p>
										</div>
									</div>
								@else
									<div class="table table-responsive">
										<table class="table table-striped">
											<tr>
												<th>Nombre</th>
												<th>Email</th>
												<th>Mensaje</th>
												<th class="text-center">Responder</th>
												<th class="text-center">Eliminiar</th>
											</tr>
											@foreach($mensajes as $mensaje)
												<tr>
													<td>{{$mensaje->nombre}}</td>
													<td>{{$mensaje->email}}</td>
													<td>{{substr($mensaje->contenido,0,30)}}</td>
													<td class="text-center">
														<!-- Button trigger modal -->
														<button type="button" class="btn btn-info" data-toggle="modal" data-target="#responser_{{$mensaje->id}}">
														  <i class="fa fa-undo"></i>
														</button>

														<!-- Modal -->
														<div class="modal fade" id="responser_{{$mensaje->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
														  	<div class="modal-dialog modal-lg" role="document">
														    	<div class="modal-content text-left">
														      		<div class="modal-header bg-gradient-info">
														        		<h5 class="modal-title" id="exampleModalLabel">
														        			<i class="fa fa-envelope"></i>
														        			Responder mensaje
														        		</h5>
														        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														          			<span aria-hidden="true">&times;</span>
														        		</button>
														      		</div>
														      		<div class="modal-body">
														    			<form action="{{url('admin/mensaje', $mensaje->id)}}" class="form-horizontal" method="post">
														    				@csrf
														    				@method('PATCH')
														    				<div class="row">
														    					<div class="form-group col-4">
															    					<label for="">Nombre</label>
															    					<input type="text" class="form-control" value="{{$mensaje->nombre}}" readonly="">
															    				</div>
															    				<div class="form-group col-4">
															    					<label for="">Email</label>
															    					<input type="text" class="form-control" value="{{$mensaje->email}}" readonly="">
															    				</div>
															    				<div class="form-group col-4">
															    					<label for="">Fecha</label>
															    					<input type="text" class="form-control" value="{{$mensaje->created_at->format('d/m/Y H:i')}}" readonly="">
															    				</div>
															    				<div class="form-group col-12">
															    					<label for="">Mensaje</label>
															    					<textarea cols="30" rows="5" class="form-control" readonly="">{{$mensaje->contenido}}</textarea>
															    				</div>
														    				</div>
														    				<hr>
														    				@if($mensaje->hijos->count() > 0)
														    					<div class="row">
														    						<div class="col-12">
															    						<label for="">Respuestas</label>
																    					@foreach($mensaje->hijos as $hijo)
															    							<div class="form-group">
															    								<p>
															    									{{$hijo->contenido}}
															    									<br>	
																    								<small>
																    									{{$hijo->created_at->format('d/m/Y H:i')}}
																    								</small>
															    								</p>
															    							</div>
															    							<hr>
															    						@endforeach
														    						</div>
															    				</div>	
														    				@endif
														    				<div class="row">
														    					<div class="col">
														    						<div class="form-group">
															    						<label for="">Responder</label>
															    						<textarea name="respuesta" id="" cols="30" rows="5" class="form-control" placeholder="Escribe aqui tu respuesta" required=""></textarea>
															    					</div>
														    					</div>
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
																        				<i class="fa fa-paper-plane"></i>
																        				Enviar
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
														@include('ayuda.eliminar', ['id' => $mensaje->id, 'ruta' => url('admin/mensaje', $mensaje->id)])
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