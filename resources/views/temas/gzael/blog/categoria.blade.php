@extends(ttf_extends('master'))

@section('contenido')
	<div class="container">
		<div class="row">
			<div class="col-12 text-center py-5">
				<h3>Categoria {{$categoria->titulo}}</h3>
			</div>
		</div>
		<div class="row">
			@foreach($categoria->entradas as $entrada)
				<div class="col-4">
					<div class="row">
						<div class="col-12">
							<img src="{{$entrada->imagen}}" alt="" width="100%">
						</div>
						<div class="col-12">
							{{blog_extracto($entrada)}}
						</div>
						<hr>
						<div class="col-12">
							<a href="{{url('blog', $entrada->url)}}" class="btn btn-primary">
								Ver mas
							</a>
						</div>
					</div>
				</div>
			@endforeach
		</div>
	</div>
@endsection