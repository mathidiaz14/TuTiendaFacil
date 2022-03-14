<select id="orden" class="form-control">
	@if(str_contains(url()->full(), 'orden="asc"'))
		<option value="asc" selected="">Ascendente</option>
		<option value="desc">Descendente</option>
		<option value="men">Menor precio</option>
		<option value="may">Mayor precio</option>
	@elseif (str_contains(url()->full(), 'orden="desc"'))
		<option value="asc">Ascendente</option>
		<option value="desc" selected="">Descendente</option>
		<option value="men">Menor precio</option>
		<option value="may">Mayor precio</option>
	@elseif (str_contains(url()->full(), 'orden="men"'))
		<option value="asc">Ascendente</option>
		<option value="desc">Descendente</option>
		<option value="men" selected="">Menor precio</option>
		<option value="may">Mayor precio</option>
	@elseif (str_contains(url()->full(), 'orden="may"'))
		<option value="asc">Ascendente</option>
		<option value="desc">Descendente</option>
		<option value="men">Menor precio</option>
		<option value="may" selected="">Mayor precio</option>
	@else
		<option value="asc">Ascendente</option>
		<option value="desc">Descendente</option>
		<option value="men">Menor precio</option>
		<option value="may">Mayor precio</option>
	@endif
	
</select>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
	$('#orden').on('change', function() 
	{
		@if(str_contains(url()->full(), '?busqueda='))
	  		$(location).attr('href','{{url()->full()}}&orden='+this.value);
	  	@else
	  		$(location).attr('href','{{url()->full()}}?orden='+this.value);
	  	@endif
	});
</script>