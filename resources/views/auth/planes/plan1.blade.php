@extends('layouts.auth')

@section('contenido')
    <form action="{{url('registrar/plan1')}}" method="post" class="login100-form validate-form" style="padding-top: 50px;">
        @csrf
        <span class="login100-form-title p-b-43">
        	<img src="{{asset('img/favicon.png')}}" alt="" width="50">
        	<br>
        	<hr>
            <h2>Plan básico</h2>
            <hr>
        </span>
        
        @include('ayuda.alerta')

        <div class="wrap-input100">
            <input class="input100" type="text" name="nombre" value="{{old('nombre')}}" autofocus="" required="">
            <span class="focus-input100"></span>
            <span class="label-input100">Nombre del negocio</span>
        </div>
        <hr>
        <div class="row">
    		<div class="col-12">
    			<p style="color:#8a8a8a;">Recuerda que al subdominio que elijas se le agregara ".tutiendafacil.uy", por ejemplo "miempresa.tutiendafacil.uy"</p>
    			<br>
    			<span style="color:red; display: none;" id="error">Este subdominio ya esta usado</span>
    		</div>
        	<div class="col-7">
		        <div class="wrap-input100 validate-input url_contenedor">
					<input type="text" class="input100" name="url" id="url" required="" value="{{old('url')}}">
		            <span class="focus-input100"></span>
		            <span class="label-input100">Subdominio</span>
		        </div>
        	</div>
        	<div class="col-5">
        		<p style="font-size: 17px;margin-top: 25px;">.tutiendafacil.uy</p>
        	</div>
        </div>
        
        <div class="wrap-input100 validate-input">
			<input type="text" class="input100" name="titulo" id="titulo" required="" value="{{old('titulo')}}">
            <span class="focus-input100"></span>
            <span class="label-input100">Titulo de la web</span>
        </div>

        <div class="wrap-input100 validate-input">
			<input type="text" class="input100" name="descripcion" id="descripcion"  required="" value="{{old('descripcion')}}">
            <span class="focus-input100"></span>
            <span class="label-input100">Descripción corta</span>
        </div>
        <div class="wrap-input100">
			<input type="text" class="input100" name="codigo" id="codigo">
            <span class="focus-input100"></span>
            <span class="label-input100">¿Tienes un codigo promocional?</span>
        </div>
        <br>
        <hr>
        <div class="container-login100-form-btn">
            <button class="login100-form-btn" style="background: #00B36F;">
                Continuar
            </button>
        </div>
        <br>
        <div class="container-login100-form-btn">
            <a href="{{url('registrarse')}}" class="login100-form-btn" style="border: 2px solid #00b36f;background: none;color: #00b36f;">
                Atras
            </a>
        </div>
    </form>
@endsection

@section('scripts')
	<script>
		$(document).ready(function(tecla)
		{
            $('#url').keyup(function()
            {
                $('#url').val($('#url').val().replace(/\s/g, "-").replace(/[^ a-z0-9]+/ig,"").toLowerCase());
            });

			$('#url').focusout(function()
			{
				$.get("{{url('registrar/comprobar/plan1')}}/"+$(this).val(), function(respuesta)
				{
					if(respuesta == "si")
					{
						$('.url_contenedor').css('border-color', 'green');
						$('.url_contenedor').css('background', '#0080001f');
						$('#error').fadeOut();
						$('button').attr('disabled', false);
					}
					else
					{
						$('.url_contenedor').css('border-color', 'red');
						$('.url_contenedor').css('background', '#8000001f');
						
						$('#error').fadeIn();
						$('button').attr('disabled', true);

					}
				});
			});

		});
	</script>
@endsection