@switch($venta->estado)
	@case("comenzado")
		<span class="badge badge-secondary">
			Comenzado
		</span>
	@break

	@case("pendiente")
		<span class="badge badge-warning">
			Pago pendiente
		</span>
	@break

	@case("en_proceso")
		<span class="badge badge-info">
			Pago en proceso
		</span>
	@break

	@case("rechazado")
		<span class="badge badge-danger">
			Pago rechazado
		</span>
	@break

	@case("aprobado")
		<span class="badge badge-success">
			Pago aprobado
		</span>
	@break

	@case("entregado")
		<span class="badge badge-primary">
			Pedido entregado
		</span>
	@break

	@case("cancelado")
		<span class="badge badge-danger">
			Pedido cancelado
		</span>
	@break

	@case("devuelto")
		<span class="badge badge-warning">
			Devolución realizada
		</span>
	@break
@endswitch