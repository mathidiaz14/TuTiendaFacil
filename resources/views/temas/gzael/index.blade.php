@extends(ttf_extends('master'))

@section('css')
  <style>
    .navbar-brand span
    {
        color: white!important;
    }
  </style>
@endsection

@section('contenido')
	<section class="slider_section position-relative">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-6 mx-auto detail_container">
          <div class="detail-box">
            <h1>
              {{landing('texto_index1')}}
            </h1>
            <p>
            	{{landing('texto_index2')}}
            </p>
            <div>
              <a href="{{url('productos')}}" class="slider-link">
                Comprar ahora
              </a>
            </div>
          </div>
        </div>
        <div class="col-md-4 px-0">
          <div id="customCarousel1" class="carousel  slide" data-ride="carousel">
            <div class="carousel-inner">
              <div class="carousel-item active">
                <div class="slider_img_box">
                  <img src="{{landing('carrusel1')}}" alt="">
                </div>
              </div>
              <div class="carousel-item">
                <div class="slider_img_box">
                  <img src="{{landing('carrusel2')}}" alt="">
                </div>
              </div>
              <div class="carousel-item">
                <div class="slider_img_box">
                  <img src="{{landing('carrusel3')}}" alt="">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="carousel_btn-box">
        <a class="carousel-control-prev" href="#customCarousel1" role="button" data-slide="prev">
          <i class="fa fa-angle-left" aria-hidden="true"></i>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#customCarousel1" role="button" data-slide="next">
          <i class="fa fa-angle-right" aria-hidden="true"></i>
          <span class="sr-only">Next</span>
        </a>
      </div>
    </div>
  </section>
  <!-- end slider section -->

  <!-- category section -->

  <section class="cat_section">
    <div class="container-fluid">
      <div class="row">
        @foreach(categorias(3) as $categoria)
        	<div class="col-sm-6 col-md-4 mx-auto">
	          <div class="box cat-box1">
	            <img src="{{categoria_url_imagen($categoria->id)}}" alt="">
	            <div class="detail-box">
	              <h2>
	                {{$categoria->titulo}}
	              </h2>
	              <a href="{{categoria_url($categoria->id)}}">
	                Comprar ahora <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
	              </a>
	            </div>
	          </div>
	        </div>
	        
        @endforeach
      </div>
    </div>
  </section>

  <!-- end category section -->

  <!-- shop section -->

  <section class="shop_section layout_padding">
    <div class="container">
      <div class="heading_container heading_center">
        <h2>
          Productos destacados
        </h2>
      </div>
      <div class="row">
      	@foreach(destacados(8) as $producto)
      		<div class="col-sm-6 col-md-4 col-lg-3">
	          <div class="box">
	            <div>
	            	@if(producto_nuevo($producto->id))
						<p class="producto_nuevo">
							Nuevo
						</p>
					@endif
	                <a href="{{producto_url($producto->id)}}">
		              <div class="img-box">
		                <img src="{{producto_url_imagen($producto->id)}}">
		              </div>
		              <div class="detail-box">
		                  {{$producto->nombre}}
		                
	                  	<h6>
		                  	${{producto_precio($producto->id)}}
		                </h6>
		              </div>
	                </a>
	            </div>
	          </div>
	        </div>
      	@endforeach
      </div>
      <div class="btn-box">
        <a href="{{url('productos')}}">
          ver todos los productos
        </a>
      </div>
    </div>
  </section>

  <!-- end shop section -->

  <!-- about section -->

  <section class="about_section  ">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-4 px-0">
          <div class="img-box">
            <img src="{{landing('about_image')}}" alt="">
          </div>
        </div>
        <div class="col-md-6 mx-auto detail_container">
          <div class="detail-box">
            <div class="heading_container">
              <h2>
                Sobre nosotros
              </h2>
            </div>
            <p>
            	{{landing('sobre_nosotros')}}
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- end about section -->

  <!-- info section -->
@endsection