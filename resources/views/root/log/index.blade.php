@extends('layouts.root', ['menu_activo' => 'log'])

@section('contenido')
	<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Registros</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
              <li class="breadcrumb-item active">Registros</li>
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
                  <div class="row">
                    <div class="col">
                      <h3 class="card-title">
                        Registros
                      </h3>
                    </div>
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
                            <th>Empresa</th>
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
                              	<a href="{{url('root/empresa', $registro->empresa_id)}}">
                              		{{$registro->empresa_id == 0 ? "ROOT" : $registro->empresa->nombre }}
                              	</a>
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
