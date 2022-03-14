@switch($estado)
	@case("info")
		<span class="badge badge-info">
			INFO
		</span>
	@break

	@case("error")
		<span class="badge badge-danger">
			ERROR
		</span>
	@break

	@case("login")
		<span class="badge badge-primary">
			LOGIN
		</span>
	@break

	@case("control")
		<span class="badge badge-dark">
			REMOTO
		</span>
	@break

@endswitch
