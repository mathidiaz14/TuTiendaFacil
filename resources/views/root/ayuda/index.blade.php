@extends('layouts.root', ['menu_activo' => 'ayuda'])

@section('contenido')
	<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Ayuda</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Ayuda</li>
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
          <!-- right col (We are only adding the ID to make the widgets sortable)-->
            <section class="col-lg-12">
            	@include('ayuda.alerta')
            <!-- Map card -->
              <div class="card">
                <div class="card-header border-1">
                  <div class="row">
                    <div class="col">
                      <h3 class="card-title">
                        Seccion de ayuda
                      </h3>
                    </div>
                    <div class="col text-right">
                    	<a href="{{url('root/ayuda/entrada/create')}}" class="btn btn-success">
                    		<i class="fa fa-plus"></i>
                    		Agregar entrada
                    	</a>
											<button type="button" class="btn btn-dark" data-toggle="modal" data-target="#AgregarUsuario">
												<i class="fa fa-plus"></i>
												Agregar Categoria
											</button>

											<!-- Modal -->
											<div class="modal fade" id="AgregarUsuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
											  <div class="modal-dialog" role="document">
											    <div class="modal-content text-left">
											        <div class="modal-header">
											          <h5 class="modal-title" id="exampleModalLabel">Agregar categoria</h5>
											          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
											              <span aria-hidden="true">&times;</span>
											          </button>
											        </div>
											        <div class="modal-body">
																<form action="{{url('root/ayuda')}}" method="POST" class="form-horizontal">
																	@csrf
																	<div class="form-group">
																		<label for="">Titulo</label>
																		<input type="text" name="titulo" class="form-control" required="">
																	</div>
																	<div class="form-group">
																		<label for="">Debajo de</label>
																		<select name="parent_id" id="" class="form-control">
																			<option value="">Ninguna</option>
																			@foreach($categorias as $categoria)
																				<option value="{{$categoria->id}}">
																					{{$categoria->titulo}}
																				</option>
																			@endforeach
																		</select>
																	</div>
																	<div class="form-group text-right">
																		<button class="btn btn-info">
																			<i class="fa fa-save"></i>
																			Guardar
																		</button>
																	</div>	
																</form>          
											        </div>
												    </div>
												  </div>
												</div>
	                    </div>
	                  </div>
	                </div>
	                <div class="card-body">
										<div class="row">
											<div class="col">
												<p class="p-2 rounded bg-gradient-dark">
													Categoria principal
												</p>
											</div>
											<div class="col">
												<p class="p-2 rounded bg-gradient-secondary">
													Subcategoria
												</p>
											</div>
											<div class="col">
												<p class="p-2 rounded bg-gradient-success">
													Entrada activa
												</p>
											</div>
											<div class="col">
												<p class="p-2 rounded bg-gradient-info">
													Entrada borrador
												</p>
											</div>
											<div class="col-12">
											<hr>
												@foreach($categorias->where('parent_id', null) as $categoria)
													@include('root.ayuda.tabla', ['categoria' => $categoria])		
												@endforeach
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

@section('scripts')
  <script>
    
  </script>
@endsection