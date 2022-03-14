@extends('layouts.dashboard', ['menu_activo' => 'blog_comentario'])

@section('contenido')
	
  <div class="content-wrapper">
    
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-12">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('admin')}}">Inicio</a></li>
              <li class="breadcrumb-item">Blog</li>
              <li class="breadcrumb-item active">Comentario</li>
            </ol>
          </div>
        </div>
      </div>
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
                		<h3 class="card-title">
		                  <i class="fas fa-comments"></i>
		                  Comentarios del blog
		                </h3>
                	</div>
                </div>
            	</div>
							<div class="card-body">
								@if($comentarios->count() == 0)
									<div class="row">
										<div class="col-12 text-center text-secondary">
											<i class="fa fa-3x fa-comments"></i>
											<p>No hay ningun comentario.</p>
										</div>
									</div>
								@else
									<div class="table table-responsive">
										<table class="table table-striped">
											<tr>
												<th>Entrada</th>
												<th>Fecha</th>
												<th>Estado</th>
												<th>Aprobar</th>
												<th>Ver</th>
												<th>Eliminiar</th>
											</tr>
											@foreach($comentarios as $comentario)
												<tr>
													<td class="align-middle">
														<a href="http://{{Auth::user()->empresa->URL}}/blog/{{$comentario->entrada->url}}" target="_blank">
															{{$comentario->entrada->titulo}}
														</a>
													</td>
													<td class="align-middle">
														{{$comentario->created_at->format('d/m/Y H:i')}}
													</td>
													<td class="align-middle">
														{{$comentario->estado}}
													</td>
													<td class="align-middle">
														@if($comentario->estado == "pendiente")
															<a href="{{url('admin/blog/comentario', $comentario->id)}}" class="btn btn-success">
																<i class="fa fa-check"></i>
															</a>
														@else
															<a class="btn btn-success disabled">
																<i class="fa fa-check"></i>
															</a>
														@endif
													</td>
													<td class="align-middle">
														<!-- Button trigger modal -->
														<button type="button" class="btn btn-info" data-toggle="modal" data-target="#responder_comentario_{{$comentario->id}}">
															<i class="fa fa-eye"></i>
														</button>

														<!-- Modal -->
														<div class="modal fade" id="responder_comentario_{{$comentario->id}}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true" >
															<div class="modal-dialog" role="document">
													  		<div class="modal-content">
																	<div class="modal-header bg-gradient-info">
																		<h5>Responder comentario</h5>
																		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																			<span aria-hidden="true">&times;</span>
																		</button>
													    		</div>
													    		<div class="modal-body">
													    			@if($comentario->user_id != null)
																			<a href="{{url('admin/blog/usuario', $comentario->user_id)}}">
																				{{$comentario->usuario->nombre}}
																			</a>
																		@else
																			<p>
																				<b>
																					{{$comentario->user_name}} - {{$comentario->user_email}}
																				</b>
																			</p>
																		@endif

																		@if($comentario->parent_id != null)
																			<hr>
																				<p>En respuesta a: {{$comentario->padre->user_name}}</p>
																			<hr>
																		@endif
																		<p><b>Contenido:</b></p>
													    			<p>{{$comentario->contenido}}</p>	
													    			<hr>
													    			@if($comentario->estado == "aprobado")
														    			<form action="{{url('admin/blog/comentario')}}" method="post" class="form-horizontal">
														    				@csrf
														    				<input type="hidden" name="id" value="{{$comentario->id}}">
														    				<div class="form-group">
														    					<label for="" class="control-label">Respuesta</label>
														    					<textarea name="respuesta" id="respuesta_{{$comentario->id}}" cols="30" rows="3" class="form-control" required=""></textarea>
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
																    				<button class="btn btn-info">
															    						<i class="fa fa-paper-plane"></i>
															    						Enviar
															    					</button>
														    					</div>
														    				</div>
														    			</form>
														    		@endif
													    		</div>
													  		</div>
															</div>
														</div>
														<script>
															$('#responder_comentario_{{$comentario->id}}').on('shown.bs.modal', function () {
														    $('#respuesta_{{$comentario->id}}').focus();
															});
														</script>
													</td>
													<td class="align-middle">
														@include('ayuda.eliminar', ['id' => $comentario->id, 'ruta' => url('admin/blog/comentario', $comentario->id)])
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