@extends('layouts.root', ['menu_activo' => 'error'])

@section('contenido')
  	<div class="content-wrapper">
    
    	<div class="content-header">
      		<div class="container-fluid">
        		<div class="row mb-2">
          			<div class="col-sm-6">
            			<h1 class="m-0 text-dark">Error</h1>
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
                  				<div class="row">
                  					<div class="col">
                  						<h3 class="card-title">
		                    				#{{$error->id}}
		                    				@if($error->estado == "pendiente")
                                  <span class="badge badge-danger">Pendiente</span>
                            		@elseif($error->estado == "tomado")
                            			<span class="badge badge-warning">Tomado</span>
                            		@elseif($error->estado == "resuelto")
                            			<span class="badge badge-success">Resuelto</span>
                            		@endif
		                  				</h3>
                  					</div>
                  					<div class="col text-right">
                  						<a href="{{url('root/error')}}" class="btn btn-secondary">
                  							<i class="fa fa-chevron-left"></i>
                  							Atras
                  						</a>
                  					</div>
                  				</div>
                			</div>
                			<div class="card-body">
                  				<div class="row">
                    				<div class="col-12 col-md-6">
                    					<div class="form-group">
                    						<label for="">Empresa</label>
                    						<br>
                    						<h5><a href="{{url('root/empresa', $error->usuario->empresa->id)}}">{{$error->usuario->empresa->nombre}}</a></h5>
                    					</div>
                    				</div>
                    				<div class="col-12 col-md-6">
                    					<div class="form-group">
                    						<label for="">Usuario</label>
                    						<input type="text" class="form-control" readonly="" value="{{$error->usuario->nombre}}">
                    					</div>
                    				</div>
                					
                					<div class="col-12 col-md-6">
                    					<div class="form-group">
                    						@if($error->adjunto != null)
	                    						<a href="{{url('root/error/adjunto', $error->id)}}" class="btn btn-success">
	                    							<i class="fa fa-download"></i>
	                    							Descargar adjunto
	                    						</a>
			                    			@else
			                    				<a href="" class="btn btn-danger disabled">
	                    							<i class="fa fa-download"></i>
	                    							No hay adjunto
	                    						</a>
		                    				@endif
                    					</div>
                    				</div>

                    				<div class="col-12 col-md-6">
                    					<div class="form-group">
                    						@if($error->captura != null)
	                    						<a href="{{url('root/error/captura', $error->id)}}" class="btn btn-success" target="_blank">
	                    							<i class="fa fa-desktop"></i>
	                    							Ver captura
	                    						</a>
			                    			@else
			                    				<a href="" class="btn btn-danger disabled">
	                    							<i class="fa fa-desktop"></i>
	                    							No hay captura
	                    						</a>
		                    				@endif
                    					</div>
                    				</div>

                    				<div class="col-12">
                    					<div class="form-group">
                    						<label for="">Mensaje</label>
                    						<textarea name="" id="" cols="30" rows="5" class="form-control" readonly="">{{$error->mensaje}}</textarea>
                    					</div>
                    				</div>
                  				</div>
                  				<hr>
                  				<div class="row">
                  					@if(count($error->mensajes) == 0)
                  						<div class="col-12 text-center">
                  							<p>No hay ningun mensaje</p>
                  						</div>
                  					@endif

                  					@foreach($error->mensajes as $mensaje)
                  						<div class="col-11">
                  							<div class="form-group">
                  								<label for="">{{$mensaje->usuario->nombre}} - {{$mensaje->created_at->format('d/m/Y H:i')}}</label>
                  								<p><i class="fa fa-reply fa-rotate-180 mx-4"></i> {{$mensaje->mensaje}}</p>
                  							</div>
                  						</div>
                              <div class="col-1">
                                @include('ayuda.eliminar', ['id' => $mensaje->id, 'ruta' => url('root/mensaje/error', $mensaje->id)])
                              </div>
                  					@endforeach
                  				</div>	
                  				<hr>
                  				<div class="row">
                  					<div class="col-12">
                  						@if($error->estado != "resuelto")
                                <form action="{{url('root/mensaje/error')}}" class="form-horizontal" method="post">
                                  @csrf
                                  <input type="hidden" name="error" value="{{$error->id}}">
                                  <div class="form-group">
                                    <label for="">Responder</label>
                                    <textarea name="mensaje" id="" cols="30" rows="5" class="form-control" placeholder="Respuesta..."></textarea>
                                  </div>
                                  <div class="form-group text-right">
                                    <button class="btn btn-primary">
                                      <i class="fa fa-paper-plane"></i>
                                      Enviar
                                    </button>
                                  </div>
                                </form>
                              @else
                                <div class="alert alert-info">
                                  <p>El caso fue resuelto, debe reabrirlo para enviar un comentario.</p>
                                </div>
                              @endif
                  					</div>
                  				</div>
                			</div>
              			</div>
            		</section>
          		</div>
      		</div>
    	</section>
  	</div>
@endsection