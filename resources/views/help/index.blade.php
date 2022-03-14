@extends('layouts.ayuda')

@section('contenido')
<div id="main">
	<div class="inner">
		<header>
			<h1>Ayuda de TuTiendaFacil.uy</h1>
			<p>Aquí encontraras toda la ayuda necesaria para poder sacarle todo el provecho posible a la plataforma</p>
		</header>
		<section>
			<form action="{{url('ayuda/buscar')}}" method="get">
				@csrf
					<input type="text" name="busqueda" value="" placeholder="Deseas buscar algo en particular?">
					<br>
					<button class="prymary">
						<i class="fa fa-send"></i>
						Buscar
					</button>
			</form>
		</section>
		<section class="tiles">
			@foreach($categorias as $categoria)
				<article class="{{random_style()}}">
					<span class="image">
						<img src="{{asset('help/images/pic03.jpg')}}" alt="" />
					</span>
					<a href="{{url('ayuda/categoria', $categoria->id)}}">
						<h2>{{$categoria->titulo}}</h2>
					</a>
				</article>
			@endforeach
		</section>
	</div>
</div>
@endsection

@section('scripts')
	
@endsection