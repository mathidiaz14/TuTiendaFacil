@extends(ttf_extends('master'))

@section('contenido')
	<main>
		
		{{-- Carrusel de imagenes --}}
		
		<div class="row" style="padding-top:82px;">

			@php
				$imagenes = collect([
					['imagen' => landing('carrusel1') , 'link' => url('productos')],
					['imagen' => landing('carrusel2') , 'link' => url('productos')],
					['imagen' => landing('carrusel3') , 'link' => url('productos')],			
				]);
				
			@endphp

			@include('ayuda.tema.carrusel', ['imagenes' => $imagenes])

		</div>

		{{-- Fin Carrusel de imagenes --}}
			
		{{-- Texto de landing --}}

		<div class="container">
			<div class="row p-5">
				<div class="col">
					<h1 class="texto_index1">
						{!!landing('texto_index1')!!}
					</h1>
				</div>
				<div class="col">
					<h4 class="texto_index2">
						{!!landing('texto_index2')!!}
					</h4>
				</div>
			</div>

		</div>		
		{{-- Fin Texto de landing --}}

		{{-- Productos destacados --}}
			
		@if(destacados()->count() > 0)
			<div class="row">
				<div class="col-12 col-md-2 text-center bg-dark text-white pb-4" style="display: table; height: 500px; overflow: hidden;">
					<h2 style="display: table-cell; vertical-align: middle;">
						Productos destacados
					</h2>
				</div>

				<div class="col-12 col-md-10">
					<div class="row">
						
						@foreach(destacados(4) as $producto)
							<div class="col-6 col-md text-center producto my-2">
								@if(producto_nuevo($producto->id))
									<p class="producto_nuevo">
										Nuevo
									</p>
								@endif
								<a href="{{producto_url($producto->id)}}">
									<div class="imagen_producto">
										<img src="{{producto_url_imagen($producto->id)}}" alt="" width="100%">
										<div class="texto_producto">
											<h3><i class="fa fa-link"></i></h3>
										</div>
									</div>
									<p>{{$producto->nombre}}</p>
									
									@if($producto->precio_promocion != null)
			                            <b>${{precio_formato($producto->precio_promocion)}}</b>
										<small style="text-decoration:line-through!important;">
											${{$producto->precio}}
										</small>
			                        @else
			                            <b>${{$producto->precio}}</b>
			                        @endif
								</a>
							</div>
						@endforeach
					</div>
				</div>
			</div>
		@endif
		
		@if(destacados()->count() > 0)
			<div class="col-12">
				<div class="col text-center mt-5">
					<a href="{{url('productos')}}" class="btn text-white" style="background-color: {{landing('color2')}}; color:white;">
						<i class="fa fa-plus"></i>
						Ver todos los productos
					</a>
				</div>
			</div>
		@endif

		{{-- Fin Productos destacados --}}

		{{-- Categorias --}}
		
		@if(categorias()->count() > 0)
			<div class="row">
				@foreach(categorias(4) as $categoria)
					<div class="col-12 col-md text-center my-3">
						<div class="categoria">
							<a href="{{categoria_url($categoria->id)}}">
								<div class="imagen_categoria">
									<img src="{{categoria_url_imagen($categoria->id)}}" alt="">
								</div>
								<div class="texto_categoria">
									<h3><b>{{$categoria->titulo}}</b></h3>
								</div>
							</a>
						</div>
					</div>
				@endforeach	
			</div>
		@endif

		{{-- Fin Categorias --}}

		{{-- Productos --}}
		
		<div class="row mt-5">
			@foreach(productos(6) as $producto)		
				<div class="col-6 col-md-4  text-center producto my-2">
					@if(producto_nuevo($producto->id))
						<p class="producto_nuevo">
							Nuevo
						</p>
					@endif
					<a href="{{producto_url($producto->id)}}">
						<div class="imagen_producto">
							<img src="{{producto_url_imagen($producto->id)}}" alt="" width="100%" class="">
							<div class="texto_producto">
								<h3><i class="fa fa-link"></i></h3>
							</div>
						</div>
						<p>{{$producto->nombre}}</p>
						
						@if($producto->precio_promocion != null)
                            <b>${{precio_formato($producto->precio_promocion)}}</b>
							<small style="text-decoration:line-through!important;">
						${{precio_formato($producto->precio)}}
					</small>
                        @else
                            <b>${{precio_formato($producto->precio)}}</b>
                        @endif
					</a>
				</div>
			@endforeach
		</div>
		
			</div></div>
		<div class="row">
			<div class="col-12 text-center my-5">
				<a href="{{url('productos')}}" class="btn btn-primary">
					Ver todos los productos
				</a>
			</div>
		</div>
	</main>
@endsection