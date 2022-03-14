@extends('layouts.root', ['menu_activo' => 'venta'])

@section('contenido')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Ventas</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
              <li class="breadcrumb-item active">Ventas</li>
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
                  	<div class="col-7">
                  		<h3 class="card-title">
		                    Ventas
	                  	</h3>
                  	</div>
                  	<div class="col-5 text-right">
                  		<form action="{{url('root/venta')}}" class="form-horizontal" method="post">
                  			@csrf
                  			<div class="form-group">
                  				<div class="row">
                  					<div class="col-9">
                  						<input type="text" class="form-control" name="buscar" placeholder="Buscar venta">
                  					</div>
                  					<div class="col-3">
                  						<button class="btn btn-info btn-block">
                  							<i class="fa fa-search"></i>
                  						</button>
                  					</div>
                  				</div>
                  			</div>
                  		</form>
                  	</div>
                  </div>
                </div>
                <div class="card-body">
                	<div class="table table-responsive">
                		<table class="table table-stripped">
                			<tbody>
	                          <tr>
	                            <th>#</th>
	                            <th>Empresa</th>
	                            <th>Estado</th>
	                            <th>Fecha</th>
	                            <th>Codigo</th>
	                            <th>Ver</th>
	                          </tr>
	                          @foreach($ventas->sortByDesc('created_at') as $venta)
	                            <tr>
	                              <td>{{$venta->id}}</td>
	                              <td>
                                  <a href="{{url('root/empresa', $venta->empresa->id)}}">{{$venta->empresa->nombre}}</a> 
                                </td>
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
                    @include('ayuda.links',['link' => $ventas])
                	</div>
                </div>
              </div>
            </section>
          </div>
      </div>
    </section>
  </div>
@endsection