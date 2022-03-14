@php
	$explode = explode("?",url()->full());
	
	$orden = null;
	if(count($explode) > 1)
	{
		$explode2 = explode('=', $explode[1]);
		$orden = $explode2[1];
	}
@endphp

<select id="orden" class="form-control">
	@if($orden == "asc")
		<option value="asc" selected="">Ascendente</option>
		<option value="desc">Descendente</option>
		<option value="men">Menor precio</option>
		<option value="may">Mayor precio</option>
	@elseif ($orden == "desc")
		<option value="asc">Ascendente</option>
		<option value="desc" selected="">Descendente</option>
		<option value="men">Menor precio</option>
		<option value="may">Mayor precio</option>
	@elseif ($orden == "men")
		<option value="asc">Ascendente</option>
		<option value="desc">Descendente</option>
		<option value="men" selected="">Menor precio</option>
		<option value="may">Mayor precio</option>
	@elseif ($orden == "may")
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
	$('#orden').on('change', function() {
	  	$(location).attr('href','?orden='+this.value);
	});
</script>