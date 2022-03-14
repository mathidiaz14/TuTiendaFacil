@extends('layouts.dashboard', ['menu_activo' => 'pagina'])

@section('contenido')
	<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Paginas</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('admin')}}">Inicio</a></li>
              <li class="breadcrumb-item">Apariencia</li>
              <li class="breadcrumb-item active">Paginas</li>
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
		                  <i class="fas fa-file"></i>
		                  Páginas
		                </h3>
                	</div>
                	<div class="col text-right">
                		<a href="{{url('admin/pagina/create')}}" class="btn btn-info">
                			<i class="fa fa-plus"></i>
                			Agregar Página
                		</a>
                	</div>
                </div>
              	</div>
      				<div class="card-body">
      					@if($paginas->count() == 0)
                  <div class="row">
                    <div class="col-12 text-center text-secondary">
                      <i class="fa fa-file fa-3x"></i>
                      <p>No hay páginas creadas</p>
                    </div>
                  </div>
                @else
                  <div class="table table-responsive">
                    <table class="table table-striped">
                      <tr>
                        <th>Titulo</th>
                        <th>URL</th>
                        <th>Tipo</th>
                        <th>Editar</th>
                        <th>Eliminiar</th>
                      </tr>
                      @foreach($paginas as $pagina)
                        <tr>
                          <td>{{$pagina->titulo}}</td>
                          <td>
                            <a href="http://{{Auth::user()->empresa->URL}}/pagina/{{$pagina->url}}" target="_blank">
                              {{$pagina->url}}
                            </a>
                          </td>
                          <td>
                            {{$pagina->tipo == null ? "--" : $pagina->tipo}}
                          </td>
                          <td>
                            <a href="{{route('pagina.edit', $pagina->id)}}" class="btn btn-primary">
                              <i class="fa fa-edit"></i>
                            </a>
                          </td>
                          <td>
                            @include('ayuda.eliminar', ['id' => $pagina->id, 'ruta' => url('admin/pagina', $pagina->id)])
                          </td>
                        </tr>
                      @endforeach
                    </table>
                  </div>
                @endif
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
	</script>
@endsection