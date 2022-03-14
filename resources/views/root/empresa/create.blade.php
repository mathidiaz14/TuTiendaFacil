@extends('layouts.root', ['menu_activo' => 'empresa'])

@section('contenido')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Nueva empresa</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
              <li class="breadcrumb-item"><a href="{{url('root/empresa')}}">Empresas</a></li>
              <li class="breadcrumb-item active">Nueva empresas</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      @include('ayuda.alerta')
      <div class="container-fluid">

        <!-- Main row -->
          <div class="row">
          <!-- right col (We are only adding the ID to make the widgets sortable)-->
            <section class="col-12">
            <!-- Map card -->
              <div class="card">
                <div class="card-body">
                  <form action="{{url('root/empresa')}}" method="post" class="form-horizontal">
                    @csrf
                    <div class="row">
                      <div class="col-12">
                        <h5 class="alert alert-info"><b>Datos de la empresa</b></h5>
                      </div>
                      <div class="form-group col-12 col-md-6">
                        <label for="">Plan</label>
                        <select name="plan" id="plan" class="form-control">
                          <option value="plan1" attr-plan="plan1" attr-precio="{{opcion('plan1')}}">Plan emprendedor - ${{opcion('plan1')}}</option>
                          <option value="plan2" attr-plan="plan2" attr-precio="{{opcion('plan2')}}">Plan avanzado - ${{opcion('plan2')}}</option>
                          <option value="plan3" attr-plan="plan3" attr-precio="{{opcion('plan3')}}">Plan profesional - ${{opcion('plan3')}}</option>
                        </select>
                      </div>
                      <div class="form-group col-12 col-md-6">
                        <label for="">Precio</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text">$</span>
                          </div>
                          <input type="text" class="form-control" id="precio" name="precio" placeholder="Precio que pagara" value="{{opcion('plan1')}}" required="">
                        </div>
                      </div>
                      <div class="form-group col-12 col-md-6">
                        <label for="">Nombre de la empresa</label>
                        <input type="text" name="nombre" class="form-control" placeholder="Nombre del negocio" required="">
                      </div>
                      
                      <div class="form-group col-12 col-md-6">
                        <label for="">URL</label><span class="subdominio ml-2"><b>(La url sera del estilo empresa.tutiendafacil.uy)</b></span>
                        <div class="row">
                          
                          <input type="text" class="form-control col-5 url" name="url" placeholder="Dirección URL de la empresa" required="">
                          <span class="text-danger url_denegada" style="display:none;"><b>URL no disponible</b></span>
                          <div class="col-5 subdominio">
                            <h4>.tutiendafacil.uy</h4>
                          </div>
                          <div class="col-2">
                            <a class="btn btn-info btn-block text-white btn_comprobar">
                              <i class="fa fa-check"></i>
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <hr>
                    <div class="row">
                      <div class="col-12">
                        <h5 class="alert alert-info"><b>Datos del usuario</b></h5>
                      </div>
                      <div class="form-group col-12 col-md-6">
                        <label for="">Nombre</label>
                        <input type="text" class="form-control" name="usuario_nombre" placeholder="Nombre de usuario" required="">
                      </div>
                      <div class="form-group col-12 col-md-6">
                        <label for="">Email</label>
                        <input type="email" class="form-control" name="usuario_email" placeholder="Email de usuario" required="">
                      </div>
                      <div class="form-group col-12 col-md-6">
                        <label for="">¿Colocar una contraseña manualmente?</label>
                        <small>En caso contrario se enviara un enlace para que el usuario coloque una.</small>
                        
                        @include('ayuda.switch', ['nombre' => 'usuario_contraseña_manual', 'estado' => null])
                      </div>
                      <div class="form-group col-12 col-md-6">
                        <label for="">Contraseña</label>
                        <input type="password" class="form-control" id="usuario_contrasena" name="usuario_contraseña" placeholder="Nueva contraseña" disabled="">
                      </div>
                    </div>
                    <hr>
                    <div class="form-group text-right">
                      <button class="btn btn-info" disabled="">
                        <i class="fa fa-save"></i>
                        Guardar
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </section>
          </div>
      </div>
    </section>
  </div>
@endsection

@section('scripts')
  <script>
    $(document).ready(function()
    {
      $('#url').keyup(function()
      {
          $('#url').val($('#url').val().replace(/\s/g, "-").replace(/[^ a-z0-9]+/ig,"").toLowerCase());
      });

      $('#usuario_contraseña_manual').on('change', function()
      {
        if($('#usuario_contrasena').is(':disabled'))
        {
          $('#usuario_contrasena').prop('disabled', false);
          $('#usuario_recontrasena').prop('disabled', false);
        }else
        {
          $('#usuario_contrasena').prop('disabled', true);
          $('#usuario_recontrasena').prop('disabled', true);
        }
        
      });

      $('#plan').on('change', function()
      {
        $('#precio').val($(this).find(':selected').attr('attr-precio'));

        if($(this).find(':selected').attr('attr-plan') == "plan1")
        {
          $('.subdominio').fadeIn();
          $('.url').removeClass('col-10');
          $('.url').addClass('col-5');
        }else
        {
          $('.subdominio').hide();
          $('.url').removeClass('col-5');
          $('.url').addClass('col-10');
        }

      });

      $('.btn_comprobar').click(function()
      {
        $.get("{{url('registrar/comprobar')}}/"+$('#plan').find(':selected').attr('attr-plan')+"/"+$('.url').val(), function(respuesta)
        {
          if(respuesta == "si")
          {
            $('.url').removeClass('is-invalid');
            $('.url').addClass('is-valid');
            $('.url_denegada').hide();
            $('button').prop('disabled', false);
          }
          else
          {
            $('.url').removeClass('is-valid');
            $('.url').addClass('is-invalid'); 
            $('.url_denegada').fadeIn();
            $('button').prop('disabled', true);
          }
        });
      });
    });
  </script>
@endsection