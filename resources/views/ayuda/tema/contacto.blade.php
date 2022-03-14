@if($pagina->tipo == "contacto")

	@include('ayuda.alerta')
	<form action="{{url('contacto_empresa')}}" method="post" class="form-horizontal col-12 col-md-8 offset-md-2">
	    @csrf
	    <div class="form-group">
	        <label for="" class="form-label">Nombre</label>
	        <input type="text" class="form-control" name="nombre" required="">
	    </div>
	    <div class="form-group">
	        <label for="" class="form-label">Email</label>
	        <input type="email" class="form-control" name="email">
	    </div>
	    <div class="form-group">
	        <label for="" class="form-label">Contenido</label>
	        <textarea name="contenido" id="" cols="30" rows="5" class="form-control"></textarea>
	    </div>
	    <div class="form-group text-right">
	        <button class="btn btn-primary">
	            <i class="fa fa-send"></i>
	            Enviar
	        </button>
	    </div>
	</form>
@endif