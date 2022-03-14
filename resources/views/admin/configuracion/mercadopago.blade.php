<div class="row">
	<div class="col text-center">
		<img src="{{asset('img/mercadopago.png')}}" alt="" width="400px">
		<br><br>
		<p>Podras recibir pagos a travez de la plataforma MercadoPago</p>
		<br>
		@if($configuracion->mp_estado != "conectado")
		<a 
		href="https://auth.mercadopago.com.uy/authorization?
			client_id={{env('MP_CLIENT_ID')}}
			&response_type=code
			&platform_id=mp
			&state={{Auth::user()->empresa_id}}
			&redirect_uri={{env('MP_REDIRECT_URI')}}" class="btn btn-info px-5">
				<i class="fa fa-plug"></i>
				Conectar
		</a>
	@else
		<a href="{{url('admin/mercadopago/desconectar')}}" class="btn btn-danger">
			<i class="fa fa-times"></i>
			<i class="fa fa-plug"></i>
			Desconectar
		</a>
	@endif
	</div>
</div>