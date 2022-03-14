
	<div class="form-group">
		<label for="">Logo del sitio</label>
		<div class="row">
			<div class="col-12 col-md-2">
				@if($configuracion->logo != null)
					<img src="{{asset($configuracion->logo)}}" alt="" width="100px">
				@else
					<img src="{{asset('img/logo_default.jpg')}}" alt="" width="100px">
				@endif
			</div>
			<div class="col-12 col-md-10">
				<input type="file" name="logo" class="form-control-file">
				
				@if($configuracion->logo != null)
					<a href="{{url('admin/configuracion/eliminar/logo')}}" class="btn btn-danger mt-3 px-4">
						<i class="fa fa-trash"></i>
						Eliminar logo
					</a>
				@endif
			</div>
		</div>
	</div>
	<div class="form-group">
		<label for="">Título de la web</label>
		<input type="text" name="titulo" class="form-control" value="{{$configuracion->titulo}}" placeholder="Título de la web">
	</div>
	<div class="form-group">
		<label for="">Descripción corta</label>
		<input type="text" name="descripcion" class="form-control" value="{{$configuracion->descripcion}}" placeholder="Descripción">
	</div>
	<div class="row">
		<div class="col-12 col-md-6">
			<div class="form-group">
				<label for="">Email </label>
				<input type="text" name="email_admin" class="form-control" value="{{$configuracion->email_admin}}" required="">
			</div>
		</div>
		<div class="col-12 col-md-6">
			<div class="form-group">
				<label for="">Telefono </label>
				<input type="text" name="telefono" class="form-control" value="{{$configuracion->telefono}}" placeholder="Telefono">
			</div>
		</div>
	</div>
	<div class="form-group">
		<label for="">¿El sitio web esta en construcción?</label>
		@include('ayuda.switch', ['nombre' => 'construccion', 'estado' => $configuracion->construccion])
	</div>