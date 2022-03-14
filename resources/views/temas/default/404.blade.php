@extends(ttf_extends('master'))

@section('contenido')
    <main>
        <div class="container" style="margin-top: 200px; margin-bottom: 200px;">
            <div class="row my-5">
                <div class="col-12 text-center">
                	<h2>No pudimos encontrar esta página, intenta nuevamente.</h2>
                    <br>
                    <hr>
                    <br>
                    <h4><a href="{{URL::Previous()}}">Atras</a></h4>
                </div>
            </div>
        </div>
    </main>
@endsection
