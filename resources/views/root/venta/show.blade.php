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
                  	<div class="col">
                  		<h3 class="card-title">
	                    	Venta #{{$venta->codigo}}
	                  	</h3>
                  	</div>
                  	<div class="col text-right">
                  		<a href="{{URL::Previous()}}" class="btn btn-secondary">
                  			<i class="fa fa-chevron-left"></i>
                  			Atras
                  		</a>
                  	</div>
                  </div>
                </div>
                <div class="card-body">
                	<div class="row">
                		<div class="col-12 col-md-6">
                			<h5>Datos del pedido</h5>
                			<ul>
                				<li>
                					<p>
                					Estado: 
                						@include('ayuda.venta_estado')
                					</p>
                				</li>
                				<li><p>Precio: <b>${{$venta->precio}}</b></p></li>
                				
                				@if($venta->descuento != null) 
                					<li><p>Descuento: <b>{{$venta->descuento}}</b></p></li>
                				@endif

                				<li>
                					<p>Entrega: 
	                					@if($venta->entrega == "envio") 
	                						<b>Envio a domicilio</b>
	                					@elseif($venta->entrega == "retiro") 
	                						<b>Retiro en local "{{$venta->local->nombre}}"</b>
	                					@endif
                					</p>
                				</li>
                				<li>Observación: <b>{{$venta->observacion}}</b></li>
                			</ul>
                			
                			<hr>
                			
                			<h5>Productos</h5>
                			<ul>
                				@foreach($venta->productos as $producto)
                					<li>{{$producto->nombre}} x {{$producto->pivot->cantidad}} - ${{$producto->pivot->precio}}</li>
                				@endforeach
                			</ul>
                			<p>Total: <b>${{$venta->precio - $venta->descuento}}</b></p>
                		</div>
                		<div class="col-12 col-md-6">
                			<h5>Datos del cliente</h5>
                			<ul>
                				<li><p>Nombre: <b>{{$venta->cliente_nombre}}</b></p></li>
                				<li><p>Apellido: <b>{{$venta->cliente_apellido}}</b></p></li>
                				<li><p>Telefono: <b>{{$venta->cliente_telefono}}</b></p></li>
                				<li><p>Email: <b>{{$venta->cliente_email}}</b></p></li>
                				<li><p>Ciudad: <b>{{$venta->cliente_ciudad}}</b></p></li>
                				<li><p>Dirección: <b>{{$venta->cliente_direccion}}</b></p></li>
                				<li><p>Apartamento: <b>{{$venta->cliente_apartamento}}</b></p></li>
                				<li><p>Observación: <b>{{$venta->cliente_observacion}}</b></p></li>
                			</ul>
                			
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