@extends(ttf_extends('master'))

@section('contenido')
	<main>
		<div class="row" style="margin-top:120px; margin-bottom: 60px;">
            <div class="col text-center">
                <h1 class="categoria_titulo">
                    {{$categoria->titulo}}
                </h1>
            </div>
        </div>
        
		<div class="row">
			<div class="productos_destacados container mb-5">
                <div class="row">
                    @if($entradas->count() == 0)
                        <div class="col text-center py-5">
                            <p>No hay ninguna entrada en el blog</p>
                        </div>
                    @endif

                    @foreach($entradas as $entrada)
                        <div class="col-12">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="producto mb-3 text-center">
                                        <a href="{{blog_entrada_url($entrada)}}">
                                            <div class="imagen_producto">
                                                <b class="entrada_fecha">{{blog_fecha_entrada($entrada, "d")}} <br> {{blog_fecha_entrada($entrada, "M")}}</b>
                                               <img src="{{asset($entrada->imagen)}}" alt="" width="100%">
                                            </div>
                                            <div class="texto_producto">
                                                <h3><i class="fa fa-eye"></i></h3>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <h3>
                                        {{$entrada->titulo}} 
                                    </h3>

                                    <a href="{{blog_categoria_url($entrada->categoria)}}">
                                        <small class="badge bg-secondary text-white my-2">
                                            {{blog_categoria_titulo($entrada)}}
                                        </small>
                                    </a>
                                    
                                    <p><small>Publicado por <a href="{{blog_entrada_autor_url($entrada)}}" class="text-warning">{{blog_entrada_autor($entrada)}}</a></small></p>
                                    <hr>
                                    {!!blog_extracto($entrada)!!}
                                    <hr>
                                    <a href="{{blog_entrada_url($entrada)}}" class="btn btn-primary">
                                        Var entrada
                                    </a>
                                </div>
                            </div>    
                            <hr>
                        </div>
                    @endforeach
                </div>
            </div>
		</div>
	</main>
@endsection