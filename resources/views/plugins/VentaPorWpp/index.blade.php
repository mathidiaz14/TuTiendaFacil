@extends('layouts.dashboard', ['menu_activo' => 'ventaPorWpp'])

@section('contenido')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-6">
					<h1 class="m-0 text-dark">Ventas por WhatsApp</h1>
				</div><!-- /.col -->
				<div class="col-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="{{url('admin')}}">Inicio</a></li>
						<li class="breadcrumb-item active">WPP</li>
					</ol>
				</div>
			</div>
		</div>
	</div>

	<section class="content">
		<div class="container-fluid">
			@include('ayuda.alerta')
			<div class="card">
				<div class="card-body">
					<form action="{{url('admin/ventaPorWpp')}}" class="form-horizontal col-12 col-md-8 offset-md-2" method="post">
						@csrf
						<div class="form-group">
							<label for="">Telefono </label>
							<input type="text" class="form-control" name="telefono" placeholder="Telefono" value="@if($wpp != null) {{$wpp->telefono}} @endif">
							<p><small>Agrega el codigo del pais antes del numero (Ej.: +598 para Uruguay)</small></p>
						</div>
						<div class="form-group">
							<label for="">Texto</label>
							<textarea name="texto" id="" cols="30" rows="3" class="form-control" placeholder="Texto que se enviara por wpp">@if($wpp == null) Me interesa el producto #nombre# con el código #codigo#. ¿Podrías enviarme más detalles? @else {{$wpp->texto}} @endif</textarea>
							<small>
								<p>Utiliza los siguientes codigos si quieres que se envien datos en el mensaje.</p>
								<ul>
									<li><b>#codigo#</b>: Codigo del producto</li>
									<li><b>#nombre#</b>: Nombre del producto</li>
									<li><b>#precio#</b>: Precio del producto</li>
								</ul>
							</small>
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
	</section>	
</div>
@endsection
