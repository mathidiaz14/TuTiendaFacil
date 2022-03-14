@extends('layouts.dashboard', ['menu_activo' => 'venta'])

@section('contenido')
	<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Pedido #{{$venta->codigo}}</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('admin')}}">Inicio</a></li>
              <li class="breadcrumb-item"><a href="{{url('admin/venta')}}">Inicio</a></li>
              <li class="breadcrumb-item active">#{{$venta->codigo}}</li>
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
          <section class="col-lg-12">
          	@include('ayuda.alerta')
            <div class="card">
              <div class="card-header">
                <div class="row">
                	<div class="col">
                		<h3 class="card-title">
		                  <i class="fas fa-shopping-cart"></i>
		                  Detalles del pedido
		                </h3>
                	</div>
                	<div class="col text-right">
                		<a href="{{URL::Previous()}}" class="btn btn-default">
                			<i class="fa fa-chevron-left"></i>
                			Atras
                		</a>
                	</div>
                </div>
              	</div>
        				<div class="card-body">
        					<div class="row">
                		<div class="col-12 col-md-6">
                			<h5><b>Datos del pedido</b></h5>
                			<div class="table table-responsive">
                        <table class="table table-striped">
                          <tr>
                            <td>Fecha:</td>
                            <td><b>{{$venta->created_at->format('d/m/Y - H:i')}}</b></td>
                          </tr>
                          <tr>
                            <td>Estado:</td>
                            <td>@include('ayuda.venta_estado')</td>
                          </tr>
                          <tr>
                            <td>Precio:</td>
                            <td><b>$ {{$venta->precio}}</b></td>
                          </tr>
                          @if($venta->descuento != null) 
                            <tr>
                              <td>Descuento</td>
                              <td><b>$ -{{$venta->descuento}}</b></td>
                            </tr>
                          @endif
                          <tr>
                            <td>Entrega:</td>
                            <td>
                              <b>
                                @if($venta->entrega == "envio") 
                                  Envio a domicilio 
                                @else 
                                  Retiro en local "{{$venta->local->nombre}}"
                                @endif
                              </b>
                            </td>
                          </tr>
                          <tr>
                            <td>Codigo:</td>
                            <td><small>{{$venta->codigo}}</small></td>
                          </tr>
                          <tr>
                            <td>Observación:</td>
                            <td><b>{{$venta->observacion == null ? "--" : $venta->observacion}}</b></td>
                          </tr>
                        </table>
                      </div>
                		</div>
                		<div class="col-12 col-md-6">
                			<h5><b>Datos del cliente</b></h5>
                      <div class="table table-responsive">
                        <table class="table table-striped">
                          <tr>
                            <td>Nombre:</td>
                            <td><b>{{$venta->cliente_nombre}}</b></td>
                          </tr>
                          <tr>
                            <td>Apellido:</td>
                            <td><b>{{$venta->cliente_apellido}}</b></td>
                          </tr>
                          <tr>
                            <td>Email:</td>
                            <td><b>{{$venta->cliente_email}}</b></td>
                          </tr>
                          @if($venta->cliente_telefono != null)
                            <tr>
                              <td>Telefono:</td>
                              <td><b>{{$venta->cliente_telefono}}</b></td>
                            </tr>
                          @elseif($venta->cliente_ciudad != null)
                            <tr>
                              <td>Ciudad:</td>
                              <td><b>{{$venta->cliente_ciudad}}</b></td>
                            </tr>
                          @elseif($venta->cliente_direccion != null)
                            <tr>
                              <td>Dirección:</td>
                              <td><b>{{$venta->cliente_direccion}}</b></td>
                            </tr>
                          @elseif($venta->cliente_apartamento != null)
                            <tr>
                              <td>Apartamento:</td>
                              <td><b>{{$venta->cliente_apartamento}}</b></td>
                            </tr>
                          @elseif($venta->cliente_observacion != null)
                            <tr>
                              <td>Observación:</td>
                              <td><b>{{$venta->cliene_observacion}}</b></td>
                            </tr>
                          @endif
                        </table>
                      </div>
                		</div>
                	</div>
				        </div>
                <div class="card-footer">
                  <div class="row">
                    <div class="col-6 col-md-3">
                      @if($venta->estado == "aprobado")
                        <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#pedidoAprobado">
                          <i class="fa fa-dolly"></i>
                          Pedido entregado
                        </button>

                        <!-- Modal -->
                        <div class="modal fade deleteModal" id="pedidoAprobado" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true" >
                          <div class="modal-dialog modal-dialog-centered" role="document">
                              <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <div class="modal-body text-center">
                                    <h4>¿Desea marcar la venta como entregada?</h4>
                                    <br>
                                    <hr>
                                    <div class="row">
                                      <div class="col">
                                        <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">
                                          NO
                                        </button>
                                      </div>
                                      <div class="col">
                                        <a href="{{url('admin/venta/entregar', $venta->id)}}" class="btn btn-primary btn-block">
                                          SI
                                        </a>
                                      </div>
                                    </div>
                                </div>
                              </div>
                          </div>
                        </div>
                      @else
                        <a href="" class="btn btn-primary btn-block disabled">
                          <i class="fa fa-dolly"></i>
                          Pedido entregado
                        </a>
                      @endif
                    </div>
                    <div class="col-6 col-md-3">
                      @if(($venta->estado == "aprobado") or ($venta->estado == "entregado"))
                        <button type="button" class="btn btn-warning btn-block" data-toggle="modal" data-target="#pedidoDevolucion">
                          <i class="fa fa-undo"></i>
                          Devolución
                        </button>

                        <!-- Modal -->
                        <div class="modal fade deleteModal" id="pedidoDevolucion" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true" >
                          <div class="modal-dialog modal-dialog-centered" role="document">
                              <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <div class="modal-body text-center">
                                    <h4>¿Desea devolver el monto de la venta?</h4>
                                    <br>
                                    <hr>
                                    <div class="row">
                                      <div class="col">
                                        <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">
                                          NO
                                        </button>
                                      </div>
                                      <div class="col">
                                        <a href="{{url('admin/venta/devolver', $venta->id)}}" class="btn btn-warning btn-block">
                                          SI
                                        </a>
                                      </div>
                                    </div>
                                </div>
                              </div>
                          </div>
                        </div>
                      @else
                        <a href="" class="btn btn-warning btn-block disabled">
                          <i class="fa fa-undo"></i>
                          Devolución
                        </a>
                      @endif
                    </div>
                    <div class="col-6 col-md-3">
                      @if(($venta->estado == "pendiente") or ($venta->estado == "en_proceso"))
                        <button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#pedidoCancelado">
                          <i class="fa fa-times"></i>
                          Cancelación
                        </button>

                        <!-- Modal -->
                        <div class="modal fade deleteModal" id="pedidoCancelado" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true" >
                          <div class="modal-dialog modal-dialog-centered" role="document">
                              <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <div class="modal-body text-center">
                                    <h4>¿Desea cancelar la venta?</h4>
                                    <br>
                                    <hr>
                                    <div class="row">
                                      <div class="col">
                                        <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">
                                          NO
                                        </button>
                                      </div>
                                      <div class="col">
                                        <a href="{{url('admin/venta/cancelar', $venta->id)}}" class="btn btn-danger btn-block">
                                          SI
                                        </a>
                                      </div>
                                    </div>
                                </div>
                              </div>
                          </div>
                        </div>
                      @else
                        <a href="" class="btn btn-danger btn-block disabled">
                          <i class="fa fa-times"></i>
                          Cancelación
                        </a>
                      @endif
                    </div>
                    <div class="col-6 col-md-3">
                      <!-- Button trigger modal -->
                      <button type="button" class="btn btn-info btn-block" data-toggle="modal" data-target="#editarPedido">
                        <i class="fa fa-edit"></i>
                        Observación
                      </button>

                      <!-- Modal -->
                      <div class="modal fade" id="editarPedido" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content text-left">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">Editar observación</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                <form action="{{url('admin/venta', $venta->id)}}" class="form-horizontal" method="post">
                                  @csrf
                                  @method('PATCH')
                                  <div class="row">
                                    <div class="col">
                                      <div class="form-group">
                                        <label for="">Editar Observación</label>
                                        <textarea name="observacion" id="" cols="30" rows="3" class="form-control">{{$venta->observacion}}</textarea>
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
                    </div>
                  </div>
                </div>
            </div>

            <div class="card">
              <div class="card-header">
                <div class="row">
                  <div class="col">
                    <h3 class="card-title">
                      <i class="fas fa-shopping-cart"></i>
                      Productos
                    </h3>
                  </div>
                  <div class="col text-right">
                    
                  </div>
                </div>
                </div>
                <div class="card-body">
                  <div class="table table-responsive">
                    <table class="table table-striped">
                      <tr>
                        <th>Nombre</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                      </tr>
                      <tbody>
                        @foreach($venta->productos as $producto)
                          <tr>
                            <td>
                              <b>{{$producto->nombre}}</b>
                              <br>
                              <small>{{producto_variante($producto->pivot->variante_id)}}</small>
                            </td>
                            <td>X {{$producto->pivot->cantidad}}</td>
                            <td>${{$producto->pivot->precio}}</td>
                          </tr>
                        @endforeach
                      </tbody>
                      <tfoot>
                        @if($venta->descuento != null)
                          <tr>
                            <td></td>
                            <td>Descuento:</td>
                            <td>$ -{{$venta->descuento}}</td>
                          </tr>
                        @endif
                        <tr>
                          <td></td>
                          <td>Total:</td>
                          <td><b>${{$venta->precio - $venta->descuento}}</b></td>
                        </tr>
                      </tfoot>
                    </table>
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

@endsection