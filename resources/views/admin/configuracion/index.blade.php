@extends('layouts.dashboard', ['menu_activo' => 'configuracion'])

@section('contenido')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-6">
					<h1 class="m-0 text-dark">Configuración</h1>
				</div><!-- /.col -->
				<div class="col-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="{{url('admin')}}">Inicio</a></li>
						<li class="breadcrumb-item active">Configuración</li>
					</ol>
				</div>
			</div>
		</div>
	</div>

	<section class="content">
		
		@php
			$url = explode('?', Request::fullUrl());
			
			if(count($url) > 1)
			{
				if($url[1] == "envio=")
					$url = "envio";
				elseif($url[1] == "mercadopago=")
					$url = "mercadopago";
				else
					$url = "info";
			}else
			{
				$url = "info";
			}
		@endphp
		
		<div class="container-fluid">
			@include('ayuda.alerta')
			<ul class="nav nav-tabs" id="tab">
				<li class="nav-item">
					<a class="nav-link @if($url == 'info')  active @endif" href="#info">
						<b>Información</b>
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link @if($url == 'envio')  active @endif" href="#retiro">
						<b>Envío y retiro</b>
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link @if($url == 'mercadopago')  active @endif" href="#mercadopago">
						<b>MercadoPago</b>
					</a>
				</li>
			</ul>
			<div class="card">
				<div class="card-body">
					<form action="{{url('admin/configuracion', configuracion()->id)}}" class="form-horizontal" method="post"  enctype="multipart/form-data">
					@csrf
					@method('PATCH')
					<div class="row">
							<div class="col-12 col-md-10 offset-md-1">
								<div class="tab-content" id="myTabContent">
								  	<div class="tab-pane fade @if($url == 'info') show active @endif" id="info" role="tabpanel" aria-labelledby="home-tab">
								  		@include('admin.configuracion.informacion')
								  	</div>
								  	<div class="tab-pane fade @if($url == 'envio') show active @endif" id="retiro" role="tabpanel" aria-labelledby="profile-tab">
								  		@include('admin.configuracion.retiro')
								  	</div>
								  	<div class="tab-pane fade @if($url == 'mercadopago') show active @endif" id="mercadopago" role="tabpanel" aria-labelledby="contact-tab">
								  		@include('admin.configuracion.mercadopago')
								  	</div>
								</div>
							</div>
						</div>
						<hr>
						<div class="row text-right">
							<div class="col">
								<button class="btn btn-primary">
									<i class="fa fa-save"></i>
									Guardar
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>	
</div>
@endsection

@section('scripts')
	<script>
		$('#tab a').on('click', function (e) {
		  	e.preventDefault()
		  	$(this).tab('show')
		});
	</script>
@endsection