@extends(ttf_extends('master'))

@section('contenido')
    <main>
        <div class="row" style="margin-top:120px;">
            <div class="col text-center">
                <h1 class="categoria_titulo">Productos</h1>
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
        <div class="row">
            <div class="productos_destacados container-fluid mb-5">
                <div class="row">
                    @if($productos->count() == 0)
                        <div class="col text-center py-5">
                            <p>No hay ningun producto</p>
                        </div>
                    @endif

                    @foreach($productos as $producto)
                        <div class="col-6 col-md-4 col-lg-3 my-3 text-center">
                            <a href="{{producto_url($producto->id)}}">
                                <div class="producto mb-3">
                                    <div class="imagen_producto">
                                       <img src="{{producto_url_imagen($producto->id)}}">
                                    </div>
                                    <div class="texto_producto">
                                        <h3><i class="fa fa-eye"></i></h3>
                                    </div>
                                </div>
                                <p>{{$producto->nombre}}</p>
                                @if($producto->precio_promocion != null)
                                    <b>${{precio_formato($producto->precio_promocion)}}</b>
                                    <small>${{precio_formato($producto->precio)}}</small>
                                @else
                                    <b>${{precio_formato($producto->precio)}}</b>
                                @endif
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
@endsection