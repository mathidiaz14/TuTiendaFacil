@include('ayuda.alerta')
<form action="{{url('newsletter')}}" class="form-horizontal" method="post">
	@csrf
	<div class="row">
		<div class="col-12 col-md-6">
			<div class="form-group">
				<input type="text" class="form-control" placeholder="Suscribete a nuestra newsletter" name="email">
			</div>
		</div>
		<div class="col-12 col-md-6">
			<button class="btn btn-primary btn-block mx-3">
				<i class="fa fa-send"></i>
				Enviar
			</button>
		</div>
	</div>
</form>