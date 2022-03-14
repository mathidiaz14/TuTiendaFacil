@extends('layouts.root', ['menu_activo' => 'empresa'])

@section('contenido')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Empresas</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
              <li class="breadcrumb-item active">Empresas</li>
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
                <div class="card-header border-1">
                  <div class="row">
                    <div class="col">
                      <h3 class="card-title">
                        Empresas
                      </h3>
                    </div>
                    <div class="col text-right">
                      <a href="{{url('root/empresa/create')}}" class="btn btn-info">
                        <i class="fa fa-plus"></i>
                        Crear empresa
                      </a>
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
                            <th>URL</th>
                            <th>MP</th>
                            <th>Estado</th>
                            <th>Plan</th>
                            <th>Pago</th>
                            <th>Expira</th>
                            <th class="text-center">Ver</th>
                            <th class="text-center">Controlar</th>
                            <th class="text-center">Editar</th>
                            <th class="text-center">Deshabilitar</th>
                            <th class="text-center">Eliminar</th>
                          </tr>
                          @foreach($empresas as $empresa)
                            <tr>
                              <td>{{$empresa->id}}</td>
                              <td>{{$empresa->nombre}}</td>
                              <td><a href="http://{{$empresa->URL}}" target="_blank">{{$empresa->URL}}</a></td>
                              <td>
                                @if($empresa->configuracion->mp_estado == "conectado") Activo @else Desactivado @endif
                              </td>
                              <td>{{$empresa->estado}}</td>
                              <td>{{$empresa->plan}}</td>
                              <td>{{$empresa->pago}}</td>
                              <td>@if($empresa->expira != null) {{$empresa->expira->format('d/m/Y')}} @endif</td>
                              <td class="text-center">
                                <a href="{{url('root/empresa',$empresa->id)}}" class="btn btn-success">
                                  <i class="fa fa-eye"></i>
                                </a>
                              </td>
                              <td class="text-center">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#concederControl_{{$empresa->id}}">
                                  <i class="fa fa-laptop-house"></i>
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="concederControl_{{$empresa->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                      <div class="modal-content text-left">
                                          <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Tomar control</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                          </div>
                                          <div class="modal-body">
                                          <form action="{{url('root/empresa/controlar', $empresa->id)}}" class="form-horizontal" method="post">
                                            @csrf
                                            <div class="form-group">
                                              <label for="">Codigo</label>
                                              <input type="text" class="form-control" name="codigo" placeholder="Codigo de control">
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
                              </td>
                              <td class="text-center">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#editarEmpresa_{{$empresa->id}}">
                                  <i class="fa fa-edit"></i>
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="editarEmpresa_{{$empresa->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                      <div class="modal-content text-left">
                                          <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Editar empresa</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                          </div>
                                          <div class="modal-body">
                                          <form action="{{url('root/empresa', $empresa->id)}}" class="form-horizontal" method="post">
                                            @csrf
                                            @method('PATCH')
                                             <div class="row">
                                               <div class="form-group col-12 col-md-6">
                                                <label for="">Nombre</label>
                                                <input type="text" name="nombre" id="nombre" class="form-control" value="{{$empresa->nombre}}" required="">
                                              </div>
                                               <div class="form-group col-12 col-md-6">
                                                <label for="">RUT</label>
                                                <input type="text" name="rut" id="rut" class="form-control" value="{{$empresa->RUT}}">
                                              </div>
                                              <div class="form-group col-12 col-md-6">
                                                <label for="">URL</label>
                                                <input type="text" name="URL" id="URL" class="form-control" value="{{$empresa->URL}}">
                                              </div>
                                              <div class="form-group col-12 col-md-6">
                                                <label for="">URL1</label>
                                                <input type="text" name="URL1" id="URL1" class="form-control" value="{{$empresa->URL1}}">
                                              </div>
                                              <div class="form-group col-12 col-md-6">
                                                <label for="">URL2</label>
                                                <input type="text" name="URL2" id="URL2" class="form-control" value="{{$empresa->URL2}}">
                                              </div>
                                              <div class="form-group col-12 col-md-6">
                                                <label for="">URL3</label>
                                                <input type="text" name="URL3" id="URL3" class="form-control" value="{{$empresa->URL3}}">
                                              </div>
                                              <div class="form-group col-12 col-md-6">
                                                <label for="">Estado</label>
                                                <select name="estado" id="" class="form-control">
                                                  @if($empresa->estado == "pendiente")
                                                    <option value="pendiente" selected="">Pendiente</option>
                                                    <option value="completo">Completo</option>
                                                    <option value="creando">Creando</option>
                                                    <option value="deshabilitado">Deshabilitado</option>
                                                  @elseif($empresa->estado == "completo")
                                                    <option value="pendiente">Pendiente</option>
                                                    <option value="completo" selected="">Completo</option>
                                                    <option value="creando">Creando</option>
                                                    <option value="deshabilitado">Deshabilitado</option>
                                                  @elseif($empresa->estado == "creando")
                                                    <option value="pendiente" >Pendiente</option>
                                                    <option value="completo">Completo</option>
                                                    <option value="creando" selected="">Creando</option>
                                                    <option value="deshabilitado">Deshabilitado</option>
                                                  @elseif($empresa->estado == "deshabilitado")
                                                    <option value="pendiente" >Pendiente</option>
                                                    <option value="completo">Completo</option>
                                                    <option value="creando">Creando</option>
                                                    <option value="deshabilitado" selected="">Deshabilitado</option>
                                                  @endif
                                                </select>
                                              </div>
                                              <div class="form-group col-12 col-md-6">
                                                <label for="">Plan</label>
                                                <select name="plan" id="plan" class="form-control">
                                                  @if($empresa->plan == "plan1")
                                                    <option value="plan1" selected="">Plan 1</option>
                                                  @else
                                                    <option value="plan1">Plan 1</option>
                                                  @endif

                                                  @if($empresa->plan == "plan2")
                                                    <option value="plan2" selected="">Plan 2</option>
                                                  @else
                                                    <option value="plan2">Plan 2</option>
                                                  @endif

                                                  @if($empresa->plan == "plan3")
                                                    <option value="plan3" selected="">Plan 3</option>
                                                  @else
                                                    <option value="plan3">Plan 3</option>
                                                  @endif
                                                  
                                                  
                                                </select>
                                              </div>
                                              <div class="form-group col-12 col-md-6">
                                                <label for="">Expira</label>
                                                <input type="date" name="expira" id="expira" class="form-control" value="@if($empresa->expira != null){{$empresa->expira->format('Y-m-d')}}@endif">                                              </div>
                                              <div class="form-group col-12 col-md-6">
                                                <label for="">Pago</label>
                                                <input type="text" name="pago" id="pago" class="form-control" value="{{$empresa->pago}}" disabled>
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
                              <td class="text-center">
                                @if($empresa->estado != "deshabilitado")
                                  <a href="{{url('root/empresa/deshabilitar', $empresa->id)}}" class="btn btn-warning">
                                    <i class="fa fa-times"></i>
                                  </a>
                                @else
                                  <a href="{{url('root/empresa/deshabilitar', $empresa->id)}}" class="btn btn-success">
                                    <i class="fa fa-check"></i>
                                  </a>
                                @endif
                              </td>
                              <td class="text-center">
                                @include('ayuda.eliminar', ['id' => $empresa->id, 'ruta' => url('root/empresa', $empresa->id)])
                              </td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="row text-center">
                    {{$empresas->links()}}
                  </div>
                </div>
              </div>
            </section>
          </div>
      </div>
    </section>
  </div>
@endsection