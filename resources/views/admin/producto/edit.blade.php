@extends('layouts.dashboard', ['menu_activo' => 'producto'])

@section('css')
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/dropzone.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/dropzone.min.js"></script>
@endsection

@section('contenido')
	<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Editar producto</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('admin')}}">Inicio</a></li>
              <li class="breadcrumb-item"><a href="{{url('/admin/producto')}}">Productos</a></li>
              <li class="breadcrumb-item active">Editar</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="row">
          	<section class="col-lg-12">
          		@include('ayuda.alerta')
          		
          		@include('admin.producto.secciones.descripcion')

          		@include('admin.producto.secciones.imagen')
	            
	            @include('admin.producto.secciones.variantes')
	        </section>
        </div>
    </section>
  </div>
@endsection

@section('scripts')
	<script>
		Dropzone.autoDiscover = false;

		$(document).ready(function()
		{
			$('.summernote').summernote({
			  height: 200,   //set editable area's height
			  codemirror: { // codemirror options
			    theme: 'monokai'
			  }
			});

			$('#sku').change(function()
			{
				$('.sku_variable').html($(this).val()+" - ");
			});

			$('#nombre').keyup(function()
			{
				$('#url').val($(this).val().replace(/\s/g, "-").replace(/[^ a-z0-9áéíóúüñ]+/ig,"_"));
				$('#url2').val("{{Auth::user()->empresa->URL}}/"+$(this).val().replace(/\s/g, "-").replace(/[^ a-z0-9áéíóúüñ]+/ig,"_"));
			});

			$(function () {
			  $('[data-toggle="popover"]').popover();
			});

			$('.btn_continuar').click(function()
			{
				$('#continuar').val('si');
				$('#formProducto').submit();
			});
		});

	</script>
@endsection