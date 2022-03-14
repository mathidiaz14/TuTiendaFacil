@extends('layouts.dashboard', ['menu_activo' => 'blog_entrada'])

@section('contenido')
	
  <div class="content-wrapper">
    
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-12">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('admin')}}">Inicio</a></li>
              <li class="breadcrumb-item">Blog</li>
              <li class="breadcrumb-item active">Entradas</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    
     
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
		                  <i class="fas fa-pen"></i>
		                  Entradas del blog
		                </h3>
                	</div>
                	<div class="col text-right">
                		<a href="{{url('admin/blog/entrada/create')}}" class="btn btn-success">
                			<i class="fa fa-plus"></i>
                			Agregar entrada
                		</a>
                	</div>
                </div>
              	</div>
								<div class="card-body">
									@if($entradas->count() == 0)
										<div class="row">
											<div class="col-12 text-center text-secondary">
												<i class="fa fa-3x fa-pen"></i>
												<p>No hay ninguna entrada creada.</p>
											</div>
										</div>
									@else
										<div class="table table-responsive">
											<table class="table table-striped">
												<tr>
													<th>Imagen</th>
													<th>Titulo</th>
													<th>Categoria</th>
													<th>Estado</th>
													<th>Usuario</th>
													<th>Editar</th>
													<th>Eliminiar</th>
												</tr>
												@foreach($entradas as $entrada)
													<tr>
														<td class="align-middle">
															@if($entrada->imagen != null)
																<img src="{{asset($entrada->imagen)}}"  width="100px">
															@else
																<img src="{{asset('img/default.jpg')}}"  width="100px">
															@endif
														</td>
														<td class="align-middle">
															<a href="http://{{Auth::user()->empresa->URL}}/blog/{{$entrada->url}}">
																<b>{{$entrada->titulo}}</b>
															</a>
														</td>
														<td class="align-middle">
															{{$entrada->categoria_id != null ? $entrada->categoria->titulo : "--"}}
														</td>
														<td class="align-middle">
															@if($entrada->estado == "borrador")
																Borrador
															@else
																Publicado
															@endif
														</td>
														<td class="align-middle">
															<a href="{{url('admin/blog/usuario', $entrada->user_id)}}">
																{{$entrada->usuario->nombre}}
															</a>
														</td>
														<td class="align-middle">
															<a href="{{route('entrada.edit', $entrada->id)}}" class="btn btn-info">
																<i class="fa fa-edit"></i>
															</a>
														</td>
														<td class="align-middle">
															@include('ayuda.eliminar', ['id' => $entrada->id, 'ruta' => url('admin/blog/entrada', $entrada->id)])
														</td>
													</tr>
												@endforeach
											</table>
										</div>
									@endif
								</div>
								<div class="card-footer bg-transparent">
								<div class="row">

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
		
	</script>
@endsection