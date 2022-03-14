@extends('layouts.dashboard', ['menu_activo' => 'blog_entrada'])

@section('contenido')
	
  <div class="content-wrapper">
    
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-12">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('admin')}}">Inicio</a></li>
              <li class="breadcrumb-item">Blog</li>
              <li class="breadcrumb-item"><a href="{{url('admin/blog/entradas')}}">Entrada</a></li>
              <li class="breadcrumb-item active">Editar</li>
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
			                  <i class="fas fa-pen"></i>
			                  Editar entrada
			                </h3>
	                	</div>
	                	<div class="col text-right">
	                		<a href="{{url('admin/blog/entrada')}}" class="btn btn-secondary">
	                			<i class="fa fa-chevron-left"></i>
	                			Atras
	                		</a>
	                	</div>
	                </div>
        		</div>
						<div class="card-body">
							<form action="{{url('admin/blog/entrada', $entrada->id)}}" class="form-horizontal" method="post" enctype="multipart/form-data">
								@csrf
								@method('PATCH')
								<div class="row">
									<div class="col-12 col-md-8">
										<div class="row">
											<div class="col-12 col-md-6">
												<label for="">Titulo</label>
												<input type="text" class="form-control" name="titulo" id="titulo" placeholder="Titulo" autofocus="" value="{{$entrada->titulo}}">
											</div>

											<div class="col-12 col-md-6">
												<label for="">URL</label>
												<input type="text" class="form-control" name="url" id="url" placeholder="URL" readonly="" value="{{$entrada->url}}">
											</div>

											<div class="col-12 my-3">
												<label for="">Contenido</label>
												<textarea name="contenido" id="editor" rows="10" class="summernote form-control">{{$entrada->contenido}}</textarea>
											</div>

											<div class="col-12 mb-3">
												<label for="">Extracto</label>
												<textarea name="extracto" rows="3" class="form-control" placeholder="Extracto">{{$entrada->extracto}}</textarea>
											</div>
										</div>
									</div>
									<div class="col-12 col-md-4">
										<div class="row">
											<div class="col-12 mb-3">
												<label for="">Imagen principal</label>
												@if($entrada->imagen != null)
													<br>
													<img src="{{asset($entrada->imagen)}}" alt="" width="100px" class="mb-3">
												@endif
												<input type="file" class="form-control-file" name="imagen">
											</div>
											<div class="col-12 mb-3">
												<label for="">Meta descripción</label>
												<textarea name="meta_descripcion" rows="2" class="form-control" placeholder="Meta Descripción">{{$entrada->meta_descripcion}}</textarea>
											</div>
											<div class="col-12 mb-3">
												<label for="">Meta etiquetas</label>
												<small>Separe las etiquetas por ,</small>
												<textarea name="meta_tags" rows="2" class="form-control" placeholder="Meta etiquetas">{{$entrada->meta_tags}}</textarea>
											</div>
											<div class="col-12 mb-3">
												<label for="">Estado</label>
												<select name="estado" id="" class="form-control">
													@if($entrada->estado == "activo")
														<option value="borrador">Borrador</option>
														<option value="activo" selected="">Activo</option>
													@else
														<option value="borrador" selected="">Borrador</option>
														<option value="activo">Activo</option>
													@endif
												</select>
											</div>
											<div class="col-12 mb-3">
												<label for="">Categoria</label>
												<select name="categoria" id="" class="form-control">
													@if($entrada->categoria_id == null)
														<option value="" selected="">Ninguna</option>
													@else
														<option value="" >Ninguna</option>
													@endif

													@foreach(Auth::user()->empresa->blogCategorias as $categoria)
														@if($categoria->id == $entrada->categoria_id)
															<option value="{{$categoria->id}}" selected="">{{$categoria->titulo}}</option>
														@else
															<option value="{{$categoria->id}}">{{$categoria->titulo}}</option>
														@endif
													@endforeach
												</select>
											</div>
											<div class="col-12">
												<label for="">¿Habilitar comentarios?</label>
												<div class="onoffswitch">
												    <input type="checkbox" name="comentario_activo" class="onoffswitch-checkbox" id="comentario_activo" tabindex="0" {{$entrada->comentario_activo == "on" ? "checked" : ""}}>
												    <label class="onoffswitch-label" for="comentario_activo"></label>
												</div>
											</div>
										</div>		
									</div>
								</div>
								<div class="row">
									<div class="col text-right">
										<hr>
										<button class="btn btn-info">
											<i class="fa fa-save"></i>
											Guardar
										</button>
									</div>
								</div>
							</form>
						</div>
	        </div>

	        <div class="card">
          	<div class="card-header">
              <div class="row">
              	<div class="col">
              		<h3 class="card-title">
	                  <i class="fas fa-pen"></i>
	                  Registro de modificaciones
	                </h3>
              	</div>
              </div>
	    			</div>
						<div class="card-body">
							<div class="table table-responsive">
								<table class="table table-striped">
									@foreach($entrada->registros as $registro)
										<tr>
											<td>{{$registro->usuario->nombre}}</td>
											<td>{{$registro->created_at->format('d/m/Y H:i')}}</td>
										</tr>
									@endforeach
								</table>
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
		$(document).ready(function()
		{
			$('.summernote').summernote({
			  height: 200,   //set editable area's height
			  codemirror: { // codemirror options
			    theme: 'monokai'
			  }
			});

			$('#titulo').keyup(function()
			{
				$('#url').val($(this).val().toLowerCase().replace(/\s/g, "-").replace(/[^ a-z0-9áéíóúüñ]+/ig,"-"));
			});
		});
	</script>
@endsection