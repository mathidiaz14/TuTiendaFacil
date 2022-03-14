<div class="ml-4 my-2">
  <div class="row @if($entrada->estado == 'activo') bg-gradient-success @else bg-gradient-info @endif p-2 rounded">
    <div class="col-10">
    <i class="fa fa-reply fa-rotate-180 mr-3"></i>
      <a href="{{url('ayuda/entrada', $entrada->id)}}" class="text-white" target="_blank">
        {{$entrada->titulo}} - <b>{{$entrada->estado}}</b>
      </a>
    </div>
    <div class="col-2 text-right text-dark">
      <a href="{{url('root/ayuda/entrada', $entrada->id)}}/edit" class="btn btn-primary">
        <i class="fa fa-edit"></i>
      </a>
      @include('ayuda.eliminar', ['id' => $entrada->id, 'ruta' => url('root/ayuda/entrada', $entrada->id)])   
    </div>
  </div>
</div>
