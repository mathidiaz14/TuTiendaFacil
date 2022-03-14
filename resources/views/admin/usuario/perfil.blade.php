@extends('layouts.dashboard', ['menu_activo' => ''])

@section('contenido')
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
	<!-- Content Header (Page header) -->
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-6">
						<h1 class="m-0 text-dark">Mi perfil</h1>
					</div><!-- /.col -->
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="{{url('admin')}}">Inicio</a></li>
							<li class="breadcrumb-item active">Mi perfil</li>
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
					<section class="col-12">
						@include('ayuda.alerta')
						<div class="card">
							<div class="card-header">
								<div class="row">
									<div class="col">
										<h3 class="card-title">
											<i class="fas fa-user"></i>
											Mi perfil
										</h3>
									</div>
								</div>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-12">
										<form action="{{url('admin/perfil')}}" method="post" class="form-horizontal">
											@csrf
											<div class="row">
												<div class="form-group col-12 col-md-6">
													<label for="" class="control-label">Email</label>
													<input type="email" class="form-control" value="{{$usuario->email}}" disabled="">
												</div>
												<div class="form-group col-12 col-md-6">
													<label for="" class="control-label">Nombre</label>
													<input type="text" name="nombre" class="form-control" value="{{$usuario->nombre}}">
												</div>
												<div class="form-group col-12 col-md-6">
													<label for="" class="control-label">CI</label>
													<input type="text" name="ci" class="form-control" value="{{$usuario->ci}}">
												</div>
												
											</div>
											<hr>
											<div class="row">
												<div class="form-group col-12 col-md-6">
													<label for="" class="control-label">Contraseña</label>
													<input type="password" name="contrasena" class="form-control">
												</div>
												<div class="form-group col-12 col-md-6">
													<label for="" class="control-label">Repetir contraseña</label>
													<input type="password" name="repetir_contrasena" class="form-control">
												</div>
											</div>
											<hr>
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