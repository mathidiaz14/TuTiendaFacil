<hr>
<div class="row">
	<div class="col-12 col-md-6">
		<section class="col-lg-12 connectedSortable">
          <div class="card">
            <div class="card-header border-0">
              <h3 class="card-title">
                <i class="fas fa-pen"></i>
                Crear borrador
              </h3>
            </div>
            <div class="card-body">
            	<form action="{{url('admin/blog/entrada')}}" class="form-horizontal" method="post">
            		@csrf
            		<input type="hidden" name="url" id="url">
            		<input type="hidden" name="estado" value="borrador">
            		<div class="form-group">
            			<label for="">
            				Titulo
            			</label>
            			<input type="text" class="form-control" name="titulo" id="titulo" placeholder="Ingrese titulo">
            		</div>
            		<div class="form-group">
            			<label for="">
            				Contenido
            			</label>
            			<textarea name="contenido" id="" cols="30" rows="5" class="form-control" placeholder="Ingrese el contenido"></textarea>
            		</div>
            		<hr>
            		<div class="form-group text-right">
            			<button class="btn btn-info">
            				<i class="fa fa-save"></i>
            				Guardar
            			</button>
            		</div>
            	</form>
            </div>
          </div>
        </section>
	</div>
	<div class="col-12 col-md-6">
		<section class="col-lg-12 connectedSortable">
          <div class="card">
            <div class="card-header border-0">
              <h3 class="card-title">
                <i class="fas fa-pen"></i>
                Lista de entradas
              </h3>
            </div>
            <div class="card-body">
            	<div class="table table-responsive">
	            	<table class="table table-striped">
	            		<tbody>
			            	@foreach(Auth::user()->empresa->blogEntradas as $entrada)
			            		<tr>
			            			<td>{{$entrada->titulo}}</td>
			            			<td>{{$entrada->estado}}</td>
			            			<td>{{$entrada->created_at->format('d/m/Y H:i')}}</td>
			            		</tr>
			            	@endforeach
	            		</tbody>
	            	</table>
            	</div>
            </div>
          </div>
        </section>
	</div>
</div>

<script>
	$('#titulo').keyup(function()
	{
		$('#url').val($(this).val().toLowerCase().replace(/\s/g, "-").replace(/[^ a-z0-9áéíóúüñ]+/ig,"-"));
	});
</script>