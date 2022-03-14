@extends('layouts.root', ['menu_activo' => 'usuario'])

@section('contenido')
	<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Usuario {{$usuario->nombre}}</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
              <li class="breadcrumb-item"><a href="{{url('root/usuario')}}">Usuarios</a></li>
              <li class="breadcrumb-item active">{{$usuario->nombre}}</li>
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
                    <div class="col text-right">
                      <a href="{{url('root/usuario')}}" class="btn btn-secondary">
                        <i class="fa fa-chevron-left"></i>
                        Atras
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
                            <th>Fecha</th>
                            <th>Estado</th>
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
                    @include('ayuda.links', ['link' => $registros])
                  </div>
                </div>
              </div>
            </div>
          </div>
      </div>
    </section>
  </div>
@endsection
