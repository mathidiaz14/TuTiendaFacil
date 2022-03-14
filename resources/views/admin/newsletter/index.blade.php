@extends('layouts.dashboard', ['menu_activo' => 'newsletter'])

@section('contenido')
	<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Suscriptores</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('admin')}}">Inicio</a></li>
              <li class="breadcrumb-item active">Suscriptores</li>
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
		                  <i class="fas fa-newspaper"></i>
		                  Suscriptores
		                </h3>
                	</div>
                	<div class="col text-right">
                		<button type="button" class="btn btn-info" data-toggle="modal" data-target="#agregarSuscriptor">
										  <i class="fa fa-plus"></i>
										  Agregar suscriptor
										</button>

										<!-- Modal -->
										<div class="modal fade" id="agregarSuscriptor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
									  	<div class="modal-dialog" role="document">
									    	<div class="modal-content text-left">
									      		<div class="modal-header">
									        		<h5 class="modal-title" id="exampleModalLabel">Agregar Suscriptor</h5>
									        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									          			<span aria-hidden="true">&times;</span>
									        		</button>
									      		</div>
									      		<div class="modal-body">
									    			<form action="{{url('admin/newsletter')}}" class="form-horizontal" method="post">
									    				@csrf
									    				<div class="form-group">
									    					<label for="">Email</label>
									    					<input type="text" class="form-control" name="email" value="">
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
											        				<i class="fa fa-send"></i>
											        				Enviar
											        			</button>
									    					</div>
									    				</div>	
									    			</form>  
									      		</div>
									    	</div>
									  	</div>
									</div>
              	
              		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#listar">
									  <i class="fa fa-list"></i>
									  Listar suscriptor
									</button>

									<!-- Modal -->
									<div class="modal fade" id="listar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
									  	<div class="modal-dialog modal-lg" role="document">
									    	<div class="modal-content text-left">
									      		<div class="modal-header">
									        		<h5 class="modal-title" id="exampleModalLabel">Listar Suscriptor</h5>
									        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									          			<span aria-hidden="true">&times;</span>
									        		</button>
									      		</div>
									      		<div class="modal-body">
									    			<div class="form-horizontal">
									    				@csrf
									    				<div class="form-group">
									    					<label for="">Emails</label>
									    					<textarea name="" id="" cols="30" rows="10" class="form-control">@foreach($emails as $email){{$email->email}};@endforeach</textarea>
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
											        			
									    					</div>
									    				</div>	
									    			</div>	
									      		</div>
									    	</div>
									  	</div>
									</div>
              	</div>
            	</div>
						<div class="card-body">
							@if($emails->count() == 0)
								<div class="row">
									<div class="col-12 text-center text-secondary">
										<i class="fa fa-newspaper fa-3x"></i>
										<p>No hay suscriptores registrados</p>
									</div>
								</div>
							@else
								<div class="table table-responsive">
									<table class="table table-striped">
										<tr>
											<th>Email</th>
											<th>Editar</th>
											<th>Eliminiar</th>
										</tr>
										@foreach($emails as $email)
											<tr>
												<td>{{$email->email}}</td>
												<td>
													<!-- Button trigger modal -->
													<button type="button" class="btn btn-info" data-toggle="modal" data-target="#responser_{{$email->id}}">
													  <i class="fa fa-edit"></i>
													</button>

													<!-- Modal -->
													<div class="modal fade" id="responser_{{$email->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
													  	<div class="modal-dialog modal-lg" role="document">
													    	<div class="modal-content text-left">
													      		<div class="modal-header">
													        		<h5 class="modal-title" id="exampleModalLabel">Editar newslatter</h5>
													        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													          			<span aria-hidden="true">&times;</span>
													        		</button>
													      		</div>
													      		<div class="modal-body">
													    			<form action="{{url('admin/newsletter', $email->id)}}" class="form-horizontal" method="post">
													    				@csrf
													    				@method('PATCH')
													    				<div class="form-group">
													    					<label for="">Email</label>
													    					<input type="text" class="form-control" name="email" value="{{$email->email}}">
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
															        				<i class="fa fa-send"></i>
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
												<td>
													@include('ayuda.eliminar', ['id' => $email->id, 'ruta' => url('admin/newsletter', $email->id)])
												</td>
											</tr>
										@endforeach
									</table>
								</div>
								@include('ayuda.links', ['link' => $emails])
							@endif
						</div>
          </section>
        </div>
      </div>
    </section>
  </div>
@endsection

@section('scripts')
@endsection