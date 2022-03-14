@extends('layouts.root', ['menu_activo' => 'codigo'])

@section('contenido')
	<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Codigos promocionales</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Codigos</li>
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
                        Codigos
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
                                  <h5 class="modal-title" id="exampleModalLabel">Agregar Codigo</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                <form action="{{url('root/codigo')}}" class="form-horizontal" method="post">
                                  @csrf
                                  <div class="form-group">
                                    <label for="">Codigo</label>
                                      <div class="row">
                                        <div class="col-8">
                                          <input type="text" name="codigo" id="codigo" class="form-control" required="">
                                        </div>
                                        <div class="col-4">
                                          <a class="btn btn-info btn_contraseña btn-block">
                                              <i class="fa fa-dice"></i>
                                            </a>
                                        </div>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="">Tipo</label>
                                    <select name="tipo" class="form-control">
                                      <option value="descuento">Descuento</option>
                                      <option value="plan1">Plan 1</option>
                                      <option value="plan2">Plan 2</option>
                                      <option value="plan3">Plan 3</option>
                                    </select>
                                  </div>
                                  <div class="form-group">
                                    <label for="">Descuento</label>
                                    <input type="text" name="descuento" id="descuento" class="form-control" required="">
                                  </div>
                                  <div class="form-group">
                                    <label for="">Cantidad</label>
                                    <input type="text" name="cantidad" id="cantidad" class="form-control" required="">
                                  </div>
                                   <div class="form-group">
                                    <label for="">Email</label>
                                    <input type="email" name="email" id="email" class="form-control">
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
                            <th>Codigo</th>
                            <th>Tipo</th>
                            <th>Descuento</th>
                            <th>Cantidad</th>
                            <th>Email</th>
                            <th>Eliminar</th>
                          </tr>
                          @foreach($codigos as $codigo)
                            <tr>
                              <td>{{$codigo->codigo}}</td>
                              <td>{{$codigo->tipo}}</td>
                              <td>{{$codigo->descuento}}</td>
                              <td>{{$codigo->cantidad}}</td>
                              <td>{{$codigo->email}}</td>
                              <td>
                                @include('ayuda.eliminar', ['id' => $codigo->id, 'ruta' => url('root/codigo', $codigo->id)])
                              </td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                      {{$codigos->links()}}
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
        $('#codigo').val(Math.random().toString(36).substring(7));
      });
    });
  </script>
@endsection