@extends('layouts.root', ['menu_activo' => 'empresa'])

@section('contenido')
	<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Empresa {{$empresa->nombre}}</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
              <li class="breadcrumb-item"><a href="{{url('root/empresa')}}">Empresas</a></li>
              <li class="breadcrumb-item active">{{$empresa->nombre}}</li>
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
            <div class="col-12">
              <div class="card">
                <div class="card-header border-1">
                  <h3 class="card-title">
                    Usuarios
                  </h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-secondary btn-sm" data-card-widget="collapse" title="Collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                  </div>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="table table-responsive">
                      <table class="table table-striped">
                        <tbody>
                          <tr>
                          	<th>#</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>CI</th>
                            <th>Editar</th>
                            <th>Eliminar</th>
                          </tr>
                          @foreach($empresa->usuarios as $usuario)
                            <tr>
                            	<td>{{$usuario->id}}</td>
                              	<td>{{$usuario->nombre}}</td>
                              	<td>{{$usuario->email}}</td>
                              	<td>{{$usuario->ci}}</td>
              								<td>
              								
              									<button type="button" class="btn btn-info" data-toggle="modal" data-target="#editarUsuario_{{$usuario->id}}">
              									  <i class="fa fa-edit"></i>
              									</button>

              									<!-- Modal -->
              									<div class="modal fade" id="editarUsuario_{{$usuario->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              									    <div class="modal-dialog" role="document">
              									      <div class="modal-content text-left">
              									          <div class="modal-header">
              									            <h5 class="modal-title" id="exampleModalLabel">Editar Usuario</h5>
              									            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              									                <span aria-hidden="true">&times;</span>
              									            </button>
              									          </div>
              									          <div class="modal-body">
              									          <form action="{{url('root/usuario', $usuario->id)}}" class="form-horizontal" method="post">
              									            @csrf
              									            @method('PATCH')
              									             <div class="form-group">
              									              <label for="">Nombre</label>
              									              <input type="text" name="nombre" id="nombre" class="form-control" value="{{$usuario->nombre}}" required="">
              									            </div>
              									             <div class="form-group">
              									              <label for="">Email</label>
              									              <input type="email" name="email" id="email" class="form-control" value="{{$usuario->email}}">
              									            </div>
              									            <div class="form-group">
              									              <label for="">CI</label>
              									              <input type="text" name="ci" id="ci" class="form-control" value="{{$usuario->ci}}">
              									            </div>
              							            		<div class="form-group">
              									              	<label for="">Contraseña</label>
              										            <div class="row">
              										            	<div class="col-10">
              											              <input type="text" name="contrasena" id="contraseña" class="contraseña form-control">
              											            </div>
              										            	<div class="col-2">
              										            		<a class="btn btn-info btn_contraseña btn-block">
              										            			<i class="fa fa-dice"></i>
              										            		</a>
              										            	</div>
              									            	</div>
              									            </div>
              									            <hr>
              									            <div class="row">
              									              <div class="col">
              									                <button type="button" class="btn btn-secondary" data-dismiss="modal">
              									                  <i class="fa fa-chevron-left"></i>
              									                  Atras
              									                </button>
              									              </div>
              									              <div class="col text-right">
              									                  <button class="btn btn-primary">
              									                    <i class="fa fa-save"></i>
              									                    Guardar
              									                  </button>
              									              </div>
              									            </div>  
              									          </form>  
              									          </div>
              									      </div>
              									    </div>
              									</div>
              								</td>
                              <td>
                                @include('ayuda.eliminar', ['id' => $usuario->id, 'ruta' => url('root/usuario', $usuario->id)])
                              </td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-12">
              <div class="card collapsed-card">
                <div class="card-header border-1">
                  <h3 class="card-title">
                    Plugins instalados
                  </h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-secondary btn-sm" data-card-widget="collapse" title="Collapse">
                      <i class="fas fa-plus"></i>
                    </button>
                  </div>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="table table-responsive">
                      <table class="table table-striped">
                         <tbody>
                          <tr>
                            <th>Nombre</th>
                            <th>Estado</th>
                            <th>Fecha instalado</th>
                          </tr>
                          @foreach($empresa->plugins as $plugin)
                            <tr>
                              <td>{{$plugin->nombre}}</td>
                              <td>{{$plugin->pivot->estado}}</td>
                              <td>{{$plugin->pivot->created_at->format('d/m/Y')}}</td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>  
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-12">
              <div class="card collapsed-card">
                <div class="card-header border-1">
                  <h3 class="card-title">
                    Ventas
                  </h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-secondary btn-sm" data-card-widget="collapse" title="Collapse">
                      <i class="fas fa-plus"></i>
                    </button>
                  </div>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="table table-responsive">
                      <table class="table table-striped">
            			       <tbody>
                          <tr>
                            <th>#</th>
                            <th>Estado</th>
                            <th>Fecha</th>
                            <th>Codigo</th>
                            <th>Ver</th>
                          </tr>
                          @foreach($ventas as $venta)
                            <tr>
                              <td>{{$venta->id}}</td>
                              <td>@include('ayuda.venta_estado')</td>
                              <td>{{$venta->created_at->format('d/m/Y')}}</td>
                              <td>{{$venta->codigo}}</td>
                              <td>
                              	<a href="{{url('root/venta', $venta->id)}}" class="btn btn-success">
                              		<i class="fa fa-eye"></i>
                              	</a>
                              </td>
                            </tr>
                          @endforeach
                        </tbody>
            		      </table>	
                    </div>
                    @include('ayuda.links', ['link' => $ventas])
                  </div>
                </div>
              </div>
            </div>

            <div class="col-12">
              <div class="card collapsed-card">
                <div class="card-header border-1">
                  <h3 class="card-title">
                    Registros
                  </h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-secondary btn-sm" data-card-widget="collapse" title="Collapse">
                      <i class="fas fa-plus"></i>
                    </button>
                  </div>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="table table-responsive">
                      <table class="table table-striped">
                         <tbody>
                          <tr>
                            <th>Fecha</th>
                            <th>Estado</th>
                            <th>Usuario</th>
                            <th>Objeto</th>
                            <th>Accion</th>
                            <th>Mensaje</th>
                          </tr>
                          @foreach($registros as $registro)
                            <tr>
                              <td>
                                {{$registro->created_at->format('d/m/Y H:i')}}
                              </td>
                              <td>
                                @include('ayuda.log_estado', ['estado' => $registro->estado])
                              </td>
                              <td>
                                <a href="{{url('root/usuario', $registro->usuario_id)}}">
                                  {{$registro->usuario->nombre}}
                                </a>
                              </td>
                              <td>
                                {{$registro->objeto}}
                              </td>
                              <td>
                                {{$registro->accion}}
                              </td>
                              <td>
                                {{$registro->mensaje}}
                              </td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>  
                    </div>
                  </div>
                  @include('ayuda.links', ['link' => $registros])
                </div>
              </div>
            </div>
          </div>
      </div>
    </section>
  </div>
@endsection

@section('scripts')
	<script>
		$(document).ready(function()
		{
			$('.btn_contraseña').click(function()
			{
				$('.contraseña').val(Math.random().toString(36).substring(2));
			});
		});
	</script>
@endsection