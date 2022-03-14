@extends('layouts.ayuda')

@section('contenido')
<div id="main">
	<div class="inner">
		<header>
			<div class="row">
				<div class="col-6">
					<h1>{{$entrada->titulo}}</h1>
				</div>
				<div class="col-6" style="text-align:right; padding-top:20px;" >
					<h2><a href="{{url('ayuda/categoria', $entrada->categoria_id)}}">Atras</a></h2>
				</div>
			</div>
		</header>
		
		<p style="text-align:justify;">
			{!!$entrada->contenido!!}
		</p>
	</div>
</div>
@endsection

@section('scripts')
	
@endsection