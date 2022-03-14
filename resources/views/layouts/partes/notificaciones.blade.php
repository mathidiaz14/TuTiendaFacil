<a class="nav-link btn_notificaciones" data-toggle="dropdown" href="#">
  <i class="far fa-bell"></i>
  @if($pendiente > 0)
    <span class="badge badge-warning navbar-badge btn_notificaciones_count">
      {{$pendiente}}
    </span>
  @endif
</a>

<div class="dropdown-menu dropdown-menu-xl dropdown-menu-right">
  @if($todas->count() == 0)
    <a href="#" class="dropdown-item">
      <!-- Message Start -->
      <div class="media">
        <div class="media-body text-center text-secondary">
          <i class="fa fa-bell"></i>
          <p>No hay notificaciones</p>
        </div>
      </div>
      <!-- Message End -->
    </a>
  @else
    @foreach($todas->sortByDesc('created_at')->take(5) as $notificacion)
      <a href="{{url('admin/notificacion', $notificacion->id)}}" class="dropdown-item" style="border-bottom: solid 1px #e2e2e2">
        <div class="row">
          <div class="col-9">
            <h3 class="dropdown-item-title my-2">
              <b>{{$notificacion->titulo}}</b> 
            </h3>     
            <p class="text-sm">{{$notificacion->contenido}}</p>
          </div>
          <div class="col-3">
            @if($notificacion->estado == "pendiente")
              <span class="badge bg-success" style="width: 100%;">Nuevo</span>  
            @elseif($notificacion->estado == "noleido")
              <span class="badge bg-info" style="width: 100%;">No leido</span>  
            @endif  
            <br>
            <span class="text-muted text-sm">
              <i class="far fa-clock mr-1"></i>
              
              @if($notificacion->created_at->diffInMinutes(\Carbon\Carbon::now()) < 60)
                {{$notificacion->created_at->diffInMinutes(\Carbon\Carbon::now())}} Min
              @elseif($notificacion->created_at->diffInHours(\Carbon\Carbon::now()) < 24)
                {{$notificacion->created_at->diffInHours(\Carbon\Carbon::now())}} hor
              @elseif($notificacion->created_at->diffInHours(\Carbon\Carbon::now()) < 48)
                {{$notificacion->created_at->diffInDays(\Carbon\Carbon::now())}} dia
              @else
                {{$notificacion->created_at->diffInDays(\Carbon\Carbon::now())}} dias
              @endif

            </span>
          </div>
        </div>
      </a>
    @endforeach
  @endif
  <div class="dropdown-divider"></div>
    <a href="{{url('admin/notificacion')}}" class="dropdown-item dropdown-footer">
      <small>Ver mas</small>
    </a>
</div>

<script>
  $(document).ready(function()
  {

    $('.btn_notificaciones').click(function()
    {
      $.get("{{url('admin/notificacion/cambiar/pendiente')}}", function(result)
      {
        if(result == true)
          $('.btn_notificaciones_count').css('display', 'none');
        
      });
    });

    @foreach($nuevas as $notificacion)
      @php 
        
        $notificacion->estado = "pendiente";
        $notificacion->save();

      @endphp

      toastr.success('{{$notificacion->contenido}}', '{{$notificacion->titulo}}', 
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