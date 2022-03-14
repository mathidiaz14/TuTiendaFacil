@extends(ttf_extends('master'))

@section('css')
    <style>
        .tz-gallery
        {
            padding: 0!important;
        }
    </style>
@endsection

@section('contenido')
    <main>
        <div class="container" style="padding-top: 60px;">
            <div class="row">
                <div class="col-12 col-md-6">
                	@include('ayuda.tema.galeria_imagenes')
                </div>
                <div class="col-12 col-md-6">
                    <div class="row">
                        <div class="col-12">
                            <p class="text-secondary">{{producto_categoria($producto->id)}}</p>
                            <h2 class="nombre_producto">
                                <b>{{$producto->nombre}}</b>
                            </h2> 
                        </div>
                        <div class="col-12">
                            @if($producto->precio_promocion != null)
                            <p class="precio_tachado">
                                <b>${{precio_formato($producto->precio)}}</b>
                            </p>
                            <p class="precio">
                                <b>${{precio_formato($producto->precio_promocion)}}</b>
                            </p>
                            @else
                                <p class="precio">
                                    <b>${{precio_formato($producto->precio)}}</b>
                                </p>
                            @endif
                            <hr>
                        </div>
                        
                        <div class="col-12">
                            @include('ayuda.tema.comprar', ["producto" => $producto])
                        </div>
                        

                        <div class="col-12">
                        <hr>
                            {!! $producto->descripcion !!}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>
@endsection

@section('js')

@endsection