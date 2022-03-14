<!-- 
	Llamado del carrusel
	********************

	php
		imagenes = collect([
			['imagen' => src , 'link' => enlace ],
			['imagen' => src , 'link' => enlace ],
			['imagen' => src , 'link' => enlace ],
		]);
	endphp

	include('ayuda.carrusel', ['imagenes' => $imagenes])
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
				@if($imagen['link'] != null)
					<a href="{{$imagen['link']}}">
						<img class="d-block w-100" src="{{$imagen['imagen']}}">
					</a>
				@else
					<img class="d-block w-100" src="{{$imagen['imagen']}}">
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