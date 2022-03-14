<!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-dark navbar-info">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{url('admin')}}" class="nav-link">Inicio</a>
      </li>
    </ul>

    <ul class="navbar-nav ml-auto">

      <li class="nav-item dropdown" id="mensajes">
        
      </li>
      
      <li class="nav-item dropdown" id="notificaciones">
        
      </li>

      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <span>
            {{Auth::user()->nombre}}
            <i class="fa fa-chevron-down"></i>
          </span>
        </a>
        <div class="dropdown-menu dropdown-menu-xl dropdown-menu-right">
          <a href="{{url('admin/perfil')}}" class="dropdown-item">
            <i class="fa fa-user"></i>
            Mi perfil
          </a>
          <div class="dropdown-divider"></div>
          <a href="" class="dropdown-item text-secondary" data-toggle="modal" data-target="#modalAyuda">
              <i class="fa fa-exclamation-circle"></i>
              Reportar incidencia
          </a>
          <a href="" class="dropdown-item text-secondary" data-toggle="modal" data-target="#modalConcederControl">
              <i class="fa fa-laptop-house"></i>
              Conceder control
          </a>
          <a href="{{url('ayuda')}}" class="dropdown-item text-secondary" target="_blank">
              <i class="fa fa-question"></i>
              Ayuda
          </a>
          <div class="dropdown-divider"></div>
          <a href="" class="dropdown-item" data-toggle="modal" data-target="#modalCerrarSesion">
              <i class="fa fa-sign-out-alt"></i>
              Cerrar Sesión
          </a>
        </div>
      </li>
    </ul>
  </nav>

<!-- Modal -->
<div class="modal fade" id="modalCerrarSesion" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true" >
  <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
      <div class="modal-header bg-gradient-info">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body text-center text-secondary">
          <p><i class="fa fa-question-circle fa-3x"></i></p>
            <h4>¿Seguro que desea cerrar la sesión?</h4>
            <br>
            <hr>
            <div class="row">
              <div class="col">
                <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">
                  NO
                </button>
              </div>
              <div class="col">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn btn-info btn-block">
                        SI
                    </button>
                </form>
              </div>
            </div>
        </div>
      </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalAyuda" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true" >
  <div class="modal-dialog" role="document">
      <div class="modal-content">
      <div class="modal-header bg-gradient-info">
          <div class="col-6">
            <h6>
              <i class="fa fa-exclamation-circle"></i>
              Ayuda
            </h6>
          </div>
          <div class="col-6 text-right">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
      </div>
      <div class="modal-body">
        <form action="{{url('admin/error')}}" method="post" class="form-horizontal" enctype="multipart/form-data">
          @csrf
          <input type="hidden" id="screen" name="captura">
          <div class="row">
            <div class="col">
              <div class="form-group">
                <label for="">Usuario</label>
                <input type="text" class="form-control" value="{{Auth::user()->nombre}}" readonly="">
              </div>
            </div>
            <div class="col">
              <div class="form-group">
                <label for="">URL</label>
                <input type="text" class="form-control" name="pantalla" value="{{Request::fullUrl()}}" readonly="">
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="">Mensaje</label>
            <textarea name="mensaje" rows="3" class="form-control" required="" placeholder="Dejanos un mensaje"></textarea>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col">
                <div class="form-group">
                  <label for="">Captura de pantalla</label>
                  <a class="btn btn-info text-white px-4" onClick="generate();">
                    <i class="fa fa-laptop"></i>
                    Capturar
                  </a>
                  <span id="mensaje_screen" class="text-success" style="display: none;">
                    <i class="fa fa-check-circle fa-2x mx-2"></i>
                  </span>
                </div>
              </div>
              <div class="col">
                <div class="form-group">
                  <label for="">Adjunto</label>
                  <input type="file" class="form-control-file" name="adjunto">
                </div>
              </div>
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">
                <i class="fa fa-times"></i>
                Cerrar
              </button>
            </div>
            <div class="col text-right">
              <button class="btn btn-primary btn_ayuda">
                <i class="fa fa-paper-plane"></i>
                Enviar
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalConcederControl" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true" >
  <div class="modal-dialog" role="document">
      <div class="modal-content">
      <div class="modal-header bg-dark-info">
          <div class="col-6">
            <p>
              <i class="fa fa-laptop-house"></i>
              Conceder control
            </p>
          </div>
          <div class="col-6 text-right">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
      </div>
      <div class="modal-body">
        <div class="row text-center">
          <div class="col-12">
            <h1 id="codigo_control">#####</h1>
            <hr>
          </div>
          <div class="col-12 mt-4">
            <a class="btn btn-info btn-lg btn_generar_codigo_control text-white">
              Generar codigo
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  function generate()
  {
    $('#modalAyuda').hide();
    $('.modal-backdrop').removeClass('show');
    
    var contenido = $('html').html();
    
    $('.modal-backdrop').addClass('show');
    $('#modalAyuda').show();
    $('#screen').val(contenido);
    $('#mensaje_screen').fadeIn();
  }

  $(document).ready(function()
  {
    $('#notificaciones').load("{{url('admin/cargar/notificacion')}}");

    var refreshId = setInterval(function(){ $('#notificaciones').load("{{url('admin/cargar/notificacion')}}"); }, 30000);

    $('#mensajes').load("{{url('admin/cargar/mensaje')}}");

    var refreshId = setInterval(function(){ $('#mensajes').load("{{url('admin/cargar/mensaje')}}"); }, 30000);

    $('.btn_generar_codigo_control').click(function()
    {
      $.get("{{url('admin/generar/codigo')}}", function(result)
      {
        $('#codigo_control').html(result);
      });
    });

  });
</script>