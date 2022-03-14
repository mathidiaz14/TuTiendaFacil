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
              <li class="breadcrumb-item active">Crear</li>
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
		                  Crear pagina
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
					<form action="{{url('admin/pagina')}}" method="post" class="form-horizontal" enctype="multipart/form-data">
						@csrf
						<div class="row">
							<div class="col-12 col-md-6">
								<div class="form-group">
									<label for="" class="form-label">Titulo</label>
									<input type="text" class="form-control" name="titulo" id="titulo" placeholder="Titulo de la pagina" required="" value="{{old('titulo')}}" autofocus="">
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="form-group">
									<label for="" class="form-label">Dirección URL de la pagina</label>
									<input type="text" class="form-control" name="url" id="url" placeholder="Ejemplo: sobre-nosotros" required="" value="{{old('url')}}">
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="form-group">
									<label for="" class="form-label">
										Imagen multimedia
									</label>
									<input type="file" class="form-control-file" name="imagen" value="{{old('imagen')}}">
								</div>
							</div>
							<div class="col-12 col-md-6">
								<label for="">Tipo de página</label>
								<select name="tipo" id="" class="form-control">
									<option value="estandar">Estandar</option>
									<option value="contacto">Pagina de contacto</option>
								</select>
							</div>
						</div>
						<div class="row">
							<div class="col">
								<textarea name="contenido" id="" cols="30" rows="10" class="form-control summernote" required="">
									{{old('contenido')}}
								</textarea>
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