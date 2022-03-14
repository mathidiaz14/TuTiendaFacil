<div class='busqueda'>
	<form action="{{url('productos')}}" method='post' class='form-horizontal'>
		<div class='form-group'>
	      	<div class='input-group'>
		        <input type='text' class='form-control' id='busqueda_input' name='busqueda' placeholder='¿Qué deseas buscar?'>
	      	</div>
		</div>
	</form>
	<div class='col text-center btn_cerrar'>
		<a style='color:white!important;'>
			<i class='fa fa-times'></i> CERRAR
		</a>
	</div>
</div>

<div class='busqueda_fondo'></div>

<script>
	$(document).ready(function()
	{
		$('.btn_busqueda').click(function()
		{
			$('.busqueda').fadeIn();
			$('.busqueda_fondo').fadeIn();
			$('#busqueda_input').focus();
		});

		$('.btn_cerrar').click(function()
		{
			$('.busqueda').fadeOut();
			$('.busqueda_fondo').fadeOut();
		});

		$('.busqueda_fondo').click(function()
		{
			$('.busqueda').fadeOut();
			$('.busqueda_fondo').fadeOut();
		});			
	});
</script>