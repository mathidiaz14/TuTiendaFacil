<div class="card">
	<div class="card-header">
		<div class="row">
			<div class="col-6">
				Producto #{{$producto->id}}
			</div>
			<div class="col-6 text-right">
				<a href="{{url('admin/producto')}}" class="btn btn-secondary">
					<i class="fa fa-chevron-left"></i>
					Atras
				</a>
			</div>
		</div>
	</div>
	<div class="card-body">
		<form action="{{url('admin/producto', $producto->id)}}" class="form-horizontal" method="post" id="formProducto">
		@csrf
		@method('PATCH')
		<input type="hidden" name="continuar" id="continuar">

		<div class="row">
			<div class="col-6 col-md-2">
				<div class="form-group">
					<label for="">Codigo identificacion</label>
					<input type="text" name="sku" id="sku" class="form-control" value="{{$producto->sku}}" placeholder="Codigo SKU">
				</div>
			</div>
			<div class="col-6 col-md-5">
				<div class="form-group">
					<label for="">Nombre</label>
					<input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre del producto" value="{{$producto->nombre}}" required="">
				</div>		
			</div>
			<div class="col-12 col-md-5">
				<div class="form-group">
					<label for="">URL</label>
					<input type="text" class="form-control" id="url2" value="{{Auth::user()->empresa->URL}}/{{$producto->url}}" readonly="">
					<input type="hidden" name="url" id="url" value="{{$producto->url}}">
				</div>		
			</div>
			<div class="col-12">
				<div class="form-group">
					<label for="">Cuentanos mas sobre el producto</label>
					<textarea name="descripcion" id="editor" rows="10" class="summernote form-control" placeholder="Escribe aquí una descripción">{{$producto->descripcion}}</textarea>
				</div>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="form-group col-6 col-md-4 col-lg-3">
				<label for="">Estado</label>
				<select name="estado" id="" class="form-control">
					@if($producto->estado == "borrador")
						<option value="borrador" selected="">Borrador</option>
						<option value="activo">Activo</option>
					@else
						<option value="borrador">Borrador</option>
						<option value="activo" selected="">Activo</option>
					@endif
				</select>	
			</div>
			<div class="form-group col-6 col-md-4 col-lg-3">
				<label for="">Categoría</label>
				<select name="categoria" class="form-control">
					@if($producto->categoria_id == null)
						<option value="" selected="">Ninguna</option>
					@else
						<option value="">Ninguna</option>
					@endif

					@foreach(Auth::user()->empresa->categorias as $categoria)
						@if($categoria->id == $producto->categoria_id)
							<option value="{{$categoria->id}}" selected="">{{$categoria->titulo}}</option>
						@else
							<option value="{{$categoria->id}}">{{$categoria->titulo}}</option>
						@endif
					@endforeach
				</select>	
			</div>
			<div class="form-group col-6 col-md-4 col-lg-3">
				<label for="">Proveedor</label>
				<select name="proveedor" class="form-control">
					@if($producto->proveedor_id == null)
						<option value="" selected="">Ninguno</option>
					@else
						<option value="">Ninguno</option>
					@endif

					@foreach(Auth::user()->empresa->proveedores as $proveedor)
						@if($proveedor->id == $producto->proveedor_id)
							<option value="{{$proveedor->id}}" selected="">{{$proveedor->nombre}}</option>
						@else
							<option value="{{$proveedor->id}}">{{$proveedor->nombre}}</option>
						@endif
					@endforeach
				</select>	
			</div>
			<div class="form-group col-6 col-md-4 col-lg-3">
				<label for="">Precio general</label>
				<div class="input-group">
					<div class="input-group-prepend">
						<div class="input-group-text">$</div>
					</div>
					<input type="number" class="form-control" name="precio" placeholder="Precio de venta" value="{{$producto->precio}}" required="">
				</div>
			</div>
			<div class="form-group col-6 col-md-4 col-lg-3">
				<label for="">Precio descuento</label>
				<div class="input-group">
					<div class="input-group-prepend">
						<div class="input-group-text">$</div>
					</div>
					<input type="number" class="form-control" name="precio_promocion" placeholder="Precio de venta" value="{{$producto->precio_promocion}}">
				</div>
			</div>
			<div class="form-group col-6 col-md-4 col-lg-3">
				<label for="">Costo de fabricación</label>
				<div class="input-group">
					<div class="input-group-prepend">
						<div class="input-group-text">$</div>
					</div>
					<input type="number" class="form-control" id="costo" name="costo" placeholder="Costo del producto" value="{{$producto->costo}}">
				</div>
			</div>
			<div class="form-group col-6 col-md-4 col-lg-3">
				<label for="">Stock del producto</label>
				<button type="button" class="btn btn-xs btn-secondary" data-container="body" data-toggle="popover" data-placement="right" data-content="Utiliza esta opción solamente si no vas a agregar variantes de stock, ya que si tienes variantes este campo no se utilizara.">
				  ?
				</button>
				<div class="input-group">
					<input type="number" class="form-control" name="cantidad" placeholder="Cantidad" value="{{$producto->cantidad}}">
				</div>
			</div>
			<div class="form-group col-6 col-md-4 col-lg-3">
				<label for="">Stock mínimo del producto</label>
				<div class="input-group">
					<input type="number" class="form-control" name="minimo_producto" placeholder="Cantidad" value="{{$producto->minimo_producto}}">
				</div>
			</div>	
			<div class="form-group col-6 col-md-4 col-lg-3">
				<label for="">¿Marcar producto como nuevo?</label>
				<div class="onoffswitch">
				    <input type="checkbox" name="nuevo" class="onoffswitch-checkbox" id="producto_nuevo" tabindex="0" @if($producto->nuevo == "on") checked @endif>
				    <label class="onoffswitch-label" for="producto_nuevo"></label>
				</div>
			</div>	
			<div class="form-group col-6 col-md-4 col-lg-3">
				<label for="">¿Marcar producto como destacado?</label>
				<div class="onoffswitch">
				    <input type="checkbox" name="destacado" class="onoffswitch-checkbox" id="producto_destacado" tabindex="0" @if($producto->destacado == "on") checked @endif>
				    <label class="onoffswitch-label" for="producto_destacado"></label>
				</div>
			</div>	
		</div>
		<hr>
		<div class="row">
			<div class="col-6">
				<div class="form-group">
					<a href="{{url('admin/producto')}}" class="btn btn-default">
						<i class="fa fa-chevron-left"></i>
						Salir
					</a>
				</div>
			</div>
			<div class="col-6 text-right">
				<div class="form-group">
					<a class="btn btn-secondary btn_continuar text-white">
							<i class="fa fa-save"></i>
							Guardar y continuar
						</a>
					<button class="btn btn-primary">
						<i class="fa fa-save"></i>
						Guardar
					</button>
				</div>
			</div>
		</div>
	</form>
	</div>
</div>