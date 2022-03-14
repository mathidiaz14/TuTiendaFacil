@extends('layouts.dashboard', ['menu_activo' => 'personalizar'])

@section('contenido')
	<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Personalizar web</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('admin')}}">Inicio</a></li>
              <li class="breadcrumb-item">Web</li>
              <li class="breadcrumb-item active">Personalizar</li>
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
		                  <i class="fas fa-palette"></i>
		                  Personalizar web
		                </h3>
                	</div>
                	<div class="col text-right">
                		<!-- Button trigger modal -->
										<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalReseteoTema">
											<i class="fa fa-undo"></i>
			    						Resetear tema
										</button>

										<!-- Modal -->
										<div class="modal fade" id="modalReseteoTema" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true" >
											<div class="modal-dialog modal-dialog-centered" role="document">
										  		<div class="modal-content">
													<div class="modal-header bg-gradient-danger">
														<button type="button" class="close" data-dismiss="modal" aria-label="Close">
															<span aria-hidden="true">&times;</span>
														</button>
										    		</div>
										    		<div class="modal-body text-center">
										    			<p><i class="fa fa-exclamation-triangle fa-4x"></i></p>
										      			<h4>¿Desea resetear el tema?</h4>
										      			<br>
										            <hr>
										      			<div class="row">
										      				<div class="col">
										    						<button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">
										    							NO
										    						</button>
										      				</div>
										      				<div class="col">
										      					<a href="{{url('admin/tema/resetear/actual')}}" class="btn btn-danger btn-block">
										    							SI
											    					</a>
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
								<form action="{{url('admin/web')}}" method="post" enctype="multipart/form-data">
									@csrf
									<div class="table table-responsive">
										<table class="table table-striped">
											@foreach($landings as $landing)
												<tr>
													<td>{{$landing->titulo}}</td>
													<td>
														@if($landing->tipo == "imagen")
															@if($landing->valor != "")
																<img src="{{asset($landing->valor)}}" alt="" width="100px">
															@else
																<img src="{{asset('img/producto_default.jpg')}}" alt="" width="100px">
															@endif	
														@endif
													</td>
													<td>
														@if($landing->tipo == "imagen")
															<input type="file" class="form-control" name="{{$landing->id}}">
														@elseif($landing->tipo == "string")
															<input type="text" class="form-control" name="{{$landing->id}}" value="{{$landing->valor}}">
														@elseif($landing->tipo == "texto")
															<textarea name="{{$landing->id}}" id="" cols="30" rows="2" class="form-control">{{$landing->valor}}</textarea>
														@elseif($landing->tipo == "color")
															<input type="color" name="{{$landing->id}}" value="{{$landing->valor}}">
														@elseif($landing->tipo == "switch")
															<div class="onoffswitch">
															    <input type="checkbox" name="{{$landing->id}}" class="onoffswitch-checkbox" id="{{$landing->id}}" tabindex="0" @if($landing->valor == "on") checked @endif>
															    <label class="onoffswitch-label" for="{{$landing->id}}"></label>
															</div>	
														@endif
													</td>
												</tr>
											@endforeach
										</table>
									</div>
										<hr>
									<div class="row">
										<div class="col text-right">
											<button class="btn btn-info">
												<i class="fa fa-save"></i>
												Guardar
											</button>
										</div>
									</div>
								</form>
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
	</script>
@endsection