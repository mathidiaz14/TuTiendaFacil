@extends('layouts.auth')

@section('contenido')
    <form action="{{url('registrar/plan3')}}" method="post" class="login100-form validate-form" style="padding-top: 100px;">
        @csrf
        <div class="login100-form-title p-b-20">
          <img src="{{asset('img/favicon.png')}}" alt="" width="50">
          <br>
          <hr>
          <h5 style="color:#9d9d9d;">Solo algunos datos mas</h5>
          <hr>
        </div>
        
        @include('ayuda.alerta')
        <div class="wrap-input100">
            <input class="input100" type="text" name="nombre" value="{{old('nombre')}}" autofocus="" required="">
            <span class="focus-input100"></span>
            <span class="label-input100">Nombre del negocio</span>
        </div>
        <hr>
        <div class="row">
          <div class="col-12">
            <span style="color:red; display: none;" id="error">Este dominio ya esta usado</span>
          </div>
          <div class="col-7">
            <div class="wrap-input100 validate-input url_contenedor">
                <input type="text" class="input100" name="url" id="url" value="{{old('url')}}" autofocus="" required="">
                <span class="focus-input100"></span>
                <span class="label-input100">Elige un dominio</span>
            </div>  
          </div>
          <div class="col-5">
            <div class="wrap-input100 validate-input">
              <select id="extension" name="extension" class="input100" style="border:none;">
                <option value=".uy">.uy</option>
                <option value=".com">.com</option>
                <option value=".com.uy">.com.uy</option>
                <option value=".net">.net</option>
                <option value=".club">.club</option>
                <option value=".org">.org</option>
                <option value=".info">.info</option>
                <option value=".online">.online</option>
                <option value=".xyz">.xyz</option>
                <option value=".site">.site</option>
                <option value=".shop">.shop</option>
              </select>
              <span class="focus-input100"></span>
              <span class="label-input100">Extensión</span>
            </div>  
          </div>
        </div>
        
        <div class="wrap-input100 validate-input">
            <input type="text" class="input100" name="titulo" id="titulo" value="{{old('titulo')}}" required="">
            <span class="focus-input100"></span>
            <span class="label-input100">Titulo de la web</span>
        </div>

        <div class="wrap-input100 validate-input">
            <input type="text" class="input100" name="descripcion" id="descripcion" value="{{old('descripcion')}}" required="">
            <span class="focus-input100"></span>
            <span class="label-input100">Descripción corta</span>
        </div>

        <div class="wrap-input100">
            <input type="text" class="input100" name="codigo" id="codigo">
            <span class="focus-input100"></span>
            <span class="label-input100">¿Tienes un codigo promocional?</span>
        </div>
        <br><hr><br>
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
        $.get("{{url('registrar/comprobar/plan3')}}/"+$('#url').val()+$('#extension option:selected').text(), function(respuesta)
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

      $('#extension').on('change', function()
      {
        $.get("{{url('registrar/comprobar/plan3')}}/"+$('#url').val()+$('#extension option:selected').text(), function(respuesta)
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