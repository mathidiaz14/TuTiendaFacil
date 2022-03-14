@extends('layouts.ayuda')

@section('contenido')
<div id="main">
	<div class="inner">
		<header>
			<div class="row">
				<div class="col-6">
					<h1>Resultado</h1>
				</div>
				<div class="col-6" style="text-align:right; padding-top:20px;" >
					<h2><a href="{{url('ayuda')}}">Atras</a></h2>
				</div>
			</div>
		</header>
		<section class="tiles">
			@foreach($entradas as $entrada)
				<article class="{{random_style()}}">
					<span class="image">
						<img src="{{asset('help/images/pic03.jpg')}}" alt="" />
					</span>
					<a href="{{url('ayuda/entrada', $entrada->id)}}">
						<h2>{{$entrada->titulo}}</h2>
					</a>
				</article>
			@endforeach
		</section>
	</div>
</div>
@endsection

@section('scripts')
	
@endsection