@if(session()->has('error'))
	<div class="alert alert-danger" role="alert">
	  	{!!session('error')!!}
		{{session()->forget('error')}}
	</div>
@elseif(session()->has('exito'))
	<div class="alert alert-success" role="alert">
	  	{!!session('exito')!!}
		{{session()->forget('exito')}}
	</div>
@endif