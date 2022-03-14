<!-- 
	Llamado del carrusel
	********************

	@php
		$imagenes = collect([
			['imagen' => landing('carrusel1') , 'link' => null],
			['imagen' => landing('carrusel2') , 'link' => url('productos')],
			['imagen' => landing('carrusel3') , 'link' => url('productos')],			
		]);
	@endphp

	@include('ayuda.carrusel', ['imagenes' => $imagenes])
-->

<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
	<ol class="carousel-indicators">
		@foreach($imagenes as $imagen)
			<li data-target="#carouselExampleIndicators" data-slide-to="{{$loop->iteration - 1}}" 
				@if($loop->first) class="active" @endif></li>
		@endforeach
	</ol>
	
	<div class="carousel-inner">
		@foreach($imagenes as $imagen)
			<div class="carousel-item @if($loop->first) active @endif">
				<img class="d-block w-100" src="{{$imagen['imagen']}}">
				
				@if($imagen['link'] != null)
					<div class="carousel-caption d-none d-md-block mb-3">
						<a href="{{$imagen['link']}}" class="btn btn-primary">
							Ver mas
						</a>
					</div>
				@endif
			</div>
		@endforeach
	</div>

	<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
		<span class="carousel-control-prev-icon" aria-hidden="true"></span>
		<span class="sr-only">Previous</span>
	</a>
	<a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
		<span class="carousel-control-next-icon" aria-hidden="true"></span>
		<span class="sr-only">Next</span>
	</a>
</div>