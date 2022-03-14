@extends(ttf_extends('master'))

@section('contenido')
    <main>
        <div class="container" style="margin-top: 150px;">
            <div class="row my-5 text-center">
            	<div class="col-12">
            		<h1>{{$pagina->titulo}}</h1>
                    <hr>
                    <br>
            	</div>
        		@if($pagina->imagen != null)
            	   <div class="col-12">
            			<img src="{{asset($pagina->imagen)}}" alt="" width="100%">
            	   </div>
        		@endif
                
                <div class="col-12 text-justify mt-5">
                	{!! $pagina->contenido!!}
                </div>

                <div class="col-12 text-justify mt-5">
                    <hr>
                    @include('ayuda.tema.contacto')
                </div>
            </div>
        </div>
    </main>
@endsection

@section('js')
    
@endsection