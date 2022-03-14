<?php  

//Compruebo que tenga las vistas blog.categoria y blog.entrada en el tema visual, sino las creo basicamente.

$carpeta = resource_path('views/empresas/'.Auth::user()->empresa->id."/".Auth::user()->empresa->carpeta."/blog");

$archivos = collect(
	"entrada",
	"categoria",
	"comentario",
	"index"
);


if (!file_exists($carpeta))
    mkdir($carpeta, 0777, true);



foreach($archivos as $archivo)
{
	if(!view()->exists('empresas.'.Auth::user()->empresa->id.".".Auth::user()->empresa->carpeta.".blog.".$archivo))
	{
		copiar(
			resource_path('views/plugins/Blog/views/'.$archivo.'.blade.php'), 
			$carpeta."/".$archivo.".blade.php"
		);
	}
}
