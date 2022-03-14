@extends(ttf_extends('master'))

@section('contenido')
    <main>
        <div class="row" style="margin-top:60px;">
            <div class="col text-center">
                <h1 class="text-dark">Productos</h1>
            </div>
        </div>
        <hr>
        <div class="row mx-5">
            <div class="col col-md-9 pt-3">
                <p>{{$productos->count()}} Productos</p>
            </div>
            <div class="col col-md-3">
                @include("ayuda.tema.ordenar") 
            </div>
        </div>
        <hr>
        <section class="shop_section layout_padding">
            <div class="container">
              <div class="row">

                @if($productos->count() == 0)
                    <div class="col-12 text-center">
                        <p>No hay ningun producto</p>
                    </div>
                @endif

                @foreach($productos as $producto)
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
            </div>
        </section>
    </main>
@endsection