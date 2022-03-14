@extends(ttf_extends('master'))

@section('contenido')
	<div class="container">
		<div class="row">
			<div class="col-12 text-center py-5">
				<h1>{{$entrada->titulo}}</h1>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<img src="{{$entrada->imagen}}" alt="" width="100%">
			</div>
			<div class="col-12">
				{{$entrada->contenido}}
			</div>
		</div>
		@if($entrada->comentario_activo == "on")
			<div class="row">
				<hr>
				<div class="col-12">
					<form action="{{url('blog/comentario')}}" method="post" class="form-horizontal">
						@csrf
						<input type="hidden" name="entrada" value="{{$entrada->id}}">
						<div class="form-group">
							<label for="">Nombre</label>
							<input type="text" class="form-control" value="nombre">
						</div>
						<div class="form-group">
							<label for="">Email</label>
							<input type="text" class="form-control" value="email">
						</div>
						<div class="form-group">
							<label for="">Contenido</label>
							<textarea name="contenido" id="" cols="30" rows="10" class="form-control"></textarea>
						</div>
					</form>
				</div>
			</div>
		@endif
		<div class="row">
			@foreach($entrada->comentarios as $comentario)
				<div class="col-12">
					<div class="row">
						<div class="col-12">
							<p><b>{{$comentario->user_name}}</b></p>
						</div>
						<div class="col-12">
							<p>{{$comentario->contenido}}</p>
						</div>
					</div>
				</div>
				@if($comentario->hijos->count() > 0)
					@foreach($comentario->hijos as $hijo)
						<div class="col-12">
							<div class="row">
								<div class="col-12">
									<p><b>{{$hijo->user_name}}</b></p>
								</div>
								<div class="col-12">
									<p>{{$hijo->contenido}}</p>
								</div>
							</div>
						</div>
					@endforeach
				@endif
			@endforeach
		</div>
	</div>
@endsection