@extends('layouts.root', ['menu_activo' => 'usuario'])

@section('contenido')
	<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Usuarios</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Usuarios</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

        <!-- Main row -->
          <div class="row">
          <!-- right col (We are only adding the ID to make the widgets sortable)-->
            <section class="col-lg-12">
            <!-- Map card -->
              <div class="card">
                <div class="card-header border-1">
                  <div class="row">
                    <div class="col">
                      <h3 class="card-title">
                        Usuarios
                      </h3>
                    </div>
                    <div class="col text-right">
                      <button type="button" class="btn btn-success" data-toggle="modal" data-target="#AgregarUsuario">
                        <i class="fa fa-plus"></i>
                        Agregar
                      </button>

                      <!-- Modal -->
                      <div class="modal fade" id="AgregarUsuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content text-left">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">Agregar Usuario</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                <form action="{{url('root/usuario')}}" class="form-horizontal" method="post">
                                  @csrf
                                   <div class="form-group">
                                    <label for="">Nombre</label>
                                    <input type="text" name="nombre" id="nombre" class="form-control" required="">
                                  </div>
                                   <div class="form-group">
                                    <label for="">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" required="">
                                  </div>
                                  <div class="form-group">
                                    <label for="">CI</label>
                                    <input type="text" name="ci" id="ci" class="form-control">
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
                                  <div class="form-group">
                                    <label for="">Empresa</label>
                                    <select name="empresa" id="empresa" class="form-control">
                                      @foreach(App\Models\Empresa::all() as $empresa)
                                        <option value="{{$empresa->id}}">{{$empresa->nombre}}</option>
                                      @endforeach
                                    </select>
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
                    </div>
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
                            <th>Empresa</th>
                            <th>Tipo</th>
                            <th>Ver</th>
                            <th>Editar</th>
                            <th>Eliminar</th>
                          </tr>
                          @foreach(App\Models\User::all() as $usuario)
                            <tr>
                              <td>{{$usuario->id}}</td>
                                <td>{{$usuario->nombre}}</td>
                                <td>{{$usuario->email}}</td>
                                <td>{{$usuario->ci}}</td>
                                <td>
                                  @if($usuario->tipo == "root")
                                    ROOT
                                  @elseif($usuario->empresa_id != null)
                                      <a href="{{url('root/empresa', $usuario->empresa_id)}}">{{$usuario->empresa->nombre}}</a>
                                  @endif
                                </td>
                                <td>{{$usuario->tipo}}</td>
                                <td>
                                  <a href="{{url('root/usuario', $usuario->id)}}" class="btn btn-success">
                                    <i class="fa fa-eye"></i>
                                  </a>
                                </td>
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
                                              <div class="form-group">
                                                <label for="">Empresa</label>
                                                <select name="empresa" id="empresa" class="form-control">
                                                  @foreach(App\Models\Empresa::all() as $empresa)
                                                    @if($empresa->id == $usuario->empresa_id)
                                                      <option value="{{$empresa->id}}" selected="">{{$empresa->nombre}}</option>
                                                    @else
                                                      <option value="{{$empresa->id}}">{{$empresa->nombre}}</option>
                                                    @endif
                                                  @endforeach
                                                </select>
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
      $('.btn_contraseña').click(function()
      {
        $('.contraseña').val(Math.random().toString(36).substring(2));
      });
    });
  </script>
@endsection