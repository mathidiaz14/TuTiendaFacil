@extends('layouts.dashboard', ['menu_activo' => 'pagina'])

@section('contenido')
	<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Paginas</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('admin')}}">Inicio</a></li>
              <li class="breadcrumb-item">Web</li>
              <li class="breadcrumb-item">Paginas</li>
              <li class="breadcrumb-item active">Editar</li>
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
		                  <i class="fas fa-file"></i>
		                  Editar pagina
		                </h3>
                	</div>
                	<div class="col text-right">
                		<a href="{{url('admin/pagina')}}" class="btn btn-default">
                			<i class="fa fa-chevron-left"></i>
                			Atras
                		</a>
                	</div>
                </div>
              	</div>
				<div class="card-body">
					<form action="{{url('admin/pagina', $pagina->id)}}" method="post" class="form-horizontal" enctype="multipart/form-data">
						@csrf
						@method('PATCH')
						<div class="row">
							<div class="col-12 col-md-6">
								<div class="form-group">
									<label for="" class="form-label">Titulo</label>
									<input type="text" class="form-control" name="titulo" id="titulo" value="{{$pagina->titulo}}" required="" autofocus="">
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="form-group">
									<label for="" class="form-label">Dirección URL de la pagina</label>
									<input type="text" class="form-control" name="url" id="url" value="{{$pagina->url}}" required="">
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="form-group">
									<label for="" class="form-label">
										Imagen multimedia
									</label>
									@if($pagina->imagen != null)
										<div class="row">
											<div class="col">
												<img src="{{asset($pagina->imagen)}}" alt="" width="100px">
											</div>
											<div class="col">
												<a href="{{url('admin/pagina/eliminar/imagen', $pagina->id)}}" class="btn btn-danger">
													<i class="fa fa-trash"></i>
													Eliminar Imagen
												</a>
											</div>
										</div>
									@endif
									<br>
									<input type="file" class="form-control-file" name="imagen" value="{{old('imagen')}}">
								</div>
							</div>
							<div class="col-12 col-md-6">
								<label for="">Tipo de página</label>
								<select name="tipo" id="" class="form-control">
									@if($pagina->tipo == "contacto")
										<option value="estandar">Estandar</option>
										<option value="contacto" selected="">Pagina de contacto</option>
									@else
										<option value="estandar" selected="">Estandar</option>
										<option value="contacto">Pagina de contacto</option>
									@endif
								</select>
							</div>
						</div>
						<div class="row">
							<div class="col">
								<textarea name="contenido" id="" cols="30" rows="10" class="form-control summernote" required="">{!! $pagina->contenido !!}</textarea>
							</div>
						</div>
						<hr>
						<div class="form-group text-right">
							<button class="btn btn-primary">
								<i class="fa fa-save"></i>
								Guardar
							</button>
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
			$('#url').keyup(function()
			{
				$('#url').val($('#url').val().replace(/\s/g, "-").replace(/[^ a-z0-9áéíóúüñ]+/ig,"-").toLowerCase());
			});

			$('#titulo').keyup(function()
			{
				$('#url').val($('#titulo').val().replace(/\s/g, "-").replace(/[^ a-z0-9áéíóúüñ]+/ig,"-").toLowerCase());
			});

			$('.summernote').summernote({
			  	height: 200,   //set editable area's height
			  	codemirror: { // codemirror options
			    	theme: 'monokai'
			  	}
			});
		});
	</script>
@endsection