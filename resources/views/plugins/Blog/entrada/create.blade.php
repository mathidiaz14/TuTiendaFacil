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
              <li class="breadcrumb-item active">Crear</li>
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
		                  Crear nueva entrada del blog
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
								<form action="{{url('admin/blog/entrada')}}" class="form-horizontal" method="post" enctype="multipart/form-data">
									@csrf
									<div class="row">
										<div class="col-12 col-md-8">
											<div class="row">
												<div class="col-12 col-md-6">
													<label for="">Titulo</label>
													<input type="text" class="form-control" name="titulo" id="titulo" placeholder="Titulo" autofocus="">
												</div>

												<div class="col-12 col-md-6">
													<label for="">URL</label>
													<input type="text" class="form-control" name="url" id="url" placeholder="URL" readonly="">
												</div>

												<div class="col-12 my-3">
													<label for="">Contenido</label>
													<textarea name="contenido" id="editor" rows="10" class="summernote form-control"></textarea>
												</div>

												<div class="col-12 mb-3">
													<label for="">Extracto</label>
													<textarea name="extracto" rows="3" class="form-control" placeholder="Extracto"></textarea>
												</div>
											</div>
										</div>
										<div class="col-12 col-md-4">
											<div class="row">
												<div class="col-12 mb-3">
													<label for="">Imagen principal</label>
													<input type="file" class="form-control-file" name="imagen">
												</div>
												<div class="col-12 mb-3">
													<label for="">Meta descripción</label>
													<textarea name="meta_descripcion" rows="2" class="form-control" placeholder="Meta Descripción"></textarea>
												</div>
												<div class="col-12 mb-3">
													<label for="">Meta etiquetas</label>
													<small>Separe las etiquetas por ,</small>
													<textarea name="meta_tags" rows="2" class="form-control" placeholder="Meta etiquetas"></textarea>
												</div>
												<div class="col-12 mb-3">
													<label for="">Estado</label>
													<select name="estado" id="" class="form-control">
														<option value="borrador">Borrador</option>
														<option value="activo">Activo</option>
													</select>
												</div>
												<div class="col-12 mb-3">
													<label for="">Categoria</label>
													<select name="categoria" id="" class="form-control">
														
														
														<option value="">Ninguna</option>
														

														@foreach(Auth::user()->empresa->blogCategorias as $categoria)
																<option value="{{$categoria->id}}">{{$categoria->titulo}}</option>
														@endforeach
													</select>
												</div>
												<div class="col-12">
													<label for="">¿Habilitar comentarios?</label>
													<div class="onoffswitch">
													    <input type="checkbox" name="comentario_activo" class="onoffswitch-checkbox" id="comentario_activo" tabindex="0" checked="">
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