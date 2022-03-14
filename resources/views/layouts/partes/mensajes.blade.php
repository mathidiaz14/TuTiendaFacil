<a class="nav-link btn_mensajes" data-toggle="dropdown" href="#">
  <i class="far fa-comments"></i>
  @if($pendiente > 0)
    <span class="badge badge-danger navbar-badge btn_mensajes_count">
      {{$pendiente}}
    </span>
  @endif
</a>
<div class="dropdown-menu dropdown-menu-xl dropdown-menu-right">
  @if($todos->count() == 0)
    <a href="#" class="dropdown-item">
      <!-- Message Start -->
      <div class="media">
        <div class="media-body text-center text-secondary">
          <i class="fa fa-envelope"></i>
          <p>No hay mensajes nuevos</p>
        </div>
      </div>
      <!-- Message End -->
    </a>
  @else
    @foreach($todos->sortByDesc('created_at')->take(5) as $mensaje)
      <a href="{{url('admin/mensaje', $mensaje->id)}}" class="dropdown-item" style="border-bottom: solid 1px #e2e2e2">
        <div class="media">
          <div class="media-body">
            <div class="row">
              <div class="col-9">
                <h3 class="dropdown-item-title">
                  <b>Nuevo mensaje</b>
                </h3>    
                <p class="text-sm">{{substr($mensaje->contenido,0,50)}}</p>
              </div>
              <div class="col-3">
                @if($mensaje->estado == "pendiente")
                  <span class="badge bg-success" style="width: 100%;">Nuevo</span>  
                @elseif($mensaje->estado == "noleido")
                  <span class="badge bg-info" style="width: 100%;">No leido</span>  
                @endif
                <br>
                <span class="text-muted text-sm">
                  <i class="far fa-clock mr-1"></i>
                  @if($mensaje->created_at->diffInMinutes(\Carbon\Carbon::now()) < 60)
                    {{$mensaje->created_at->diffInMinutes(\Carbon\Carbon::now())}} Min
                  @elseif($mensaje->created_at->diffInHours(\Carbon\Carbon::now()) < 24)
                    {{$mensaje->created_at->diffInHours(\Carbon\Carbon::now())}} hor
                  @elseif($mensaje->created_at->diffInHours(\Carbon\Carbon::now()) < 48)
                    {{$mensaje->created_at->diffInDays(\Carbon\Carbon::now())}} dia
                  @else
                    {{$mensaje->created_at->diffInDays(\Carbon\Carbon::now())}} dias
                  @endif
                </span>
              </div>
            </div>
          </div>
        </div>
        <!-- Message End -->
      </a>
    @endforeach
  @endif
  <div class="dropdown-divider"></div>
  <a href="{{url('admin/mensaje')}}" class="dropdown-item dropdown-footer">
    <small>Ver mas</small>
  </a>
</div>

<script>
  $(document).ready(function()
  {

    $('.btn_mensajes').click(function()
    {
      $.get("{{url('admin/mensaje/cambiar/pendiente')}}", function(result)
      {
        if(result == true)
          $('.btn_mensajes_count').css('display', 'none');
        
      });
    });

    @foreach($nuevos as $mensaje)
      @php 
        
        $mensaje->estado = "pendiente";
        $mensaje->save();

      @endphp

      toastr.success('Nuevo contacto desde la web', 
      {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-bottom-right",
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
      });

    @endforeach    
  });
</script>