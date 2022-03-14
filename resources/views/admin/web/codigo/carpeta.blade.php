 @foreach($carpeta as $archivo)
	@if(($archivo != ".") and ($archivo != ".."))
		@php
			$flag = true;
			
			if(!is_dir($ruta."/".$archivo))
			{
				$explode = explode('.', $archivo);

				if(($explode[count($explode) - 1] != "php") and 
					($explode[count($explode) - 1] != "css") and 
					($explode[count($explode) - 1] != "js") and 
					($explode[count($explode) - 1] != "xml") and 
					($explode[count($explode) - 1] != "txt"))
					$flag = false;
			}	
		@endphp


		<div class="col-6 col-md-4 col-lg-3 my-2">
			<form action="{{url('admin/web/codigo')}}" method="post" class="form-horizontal">
				@csrf
				<input type="hidden" name="ruta" value="{{$ruta}}">
				<input type="hidden" name="archivo" value="{{$archivo}}">
				@if(is_dir($ruta."/".$archivo))
					<button class="btn btn-info btn-block">
						<i class="fa fa-folder fa-3x"></i>
						<br>
						{{$archivo}}
					</button>
				@elseif(!$flag)
					<button class="btn btn-secondary btn-block disabled" disabled="">
						<i class="fa fa-file fa-3x"></i>
						<br>
						{{$archivo}}
					</button>
				@else
					<button class="btn btn-secondary btn-block">
						<i class="fa fa-file-code fa-3x"></i>
						<br>
						{{$archivo}}
					</button>
				@endif
			</form>
		</div>
	@endif
@endforeach

@if(($ruta != resource_path('views/empresas/'.Auth::user()->empresa->id."/".Auth::user()->empresa->carpeta)) and
($ruta != resource_path('views/empresas/'.Auth::user()->empresa->id."/".Auth::user()->empresa->carpeta."/") ))
	<div class="col-6 col-md-4 col-lg-3 my-2">
		<form action="{{url('admin/web/codigo')}}" method="post" class="form-horizontal">
			@csrf
			<input type="hidden" name="ruta" value="{{$atras}}">
			<input type="hidden" name="archivo" value="">
			<button class="btn btn-secondary btn-block">
				<i class="fa fa-arrow-left fa-3x"></i>
				<br>
				Atras
			</button>
		</form>
	</div>
@endif