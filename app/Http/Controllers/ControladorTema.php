<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tema;
use App\Models\Landing;
use PhpZip\ZipFile;
use Auth;
use Storage;
use File;
use Response;

class ControladorTema extends Controller
{
    private $path = "admin.tema.";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $misTemas   = Auth::user()->empresa->temas;
        $otrosTemas = Tema::where('tipo', 'publico')->get();

        return view($this->path."index", compact('misTemas', 'otrosTemas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $file       = $request->file('archivo');

        if($file->getClientOriginalExtension() != "zip")
        {
            error("El archivo debe tener la extencion .zip");
            return back();
        }

        $nameFile   = codigo_aleatorio(10);
        $ruta       = resource_path("views/empresas/".Auth::user()->empresa->id."/".$nameFile);

        Storage::disk('public')->put($nameFile.".".$file->getClientOriginalExtension(), File::get($file));

        $reader     = new ZipFile();
        $reader->openFile(public_path("storage/".$nameFile.".".$file->getClientOriginalExtension()));

        if(!is_dir($ruta))
            mkdir($ruta);
        
        $reader->extractTo($ruta);
        $reader->close();

        if(file_exists(public_path("storage/".$nameFile.".".$file->getClientOriginalExtension())))
            unlink(public_path("storage/".$nameFile.".".$file->getClientOriginalExtension()));

        $flag       = true;
        $archivos   = collect([
            "info.xml",
            "install.xml",
            "index.blade.php",
            "master.blade.php",
            "carrito.blade.php",
            "categoria.blade.php",
            "pagina.blade.php",
            "producto.blade.php",
            "productos.blade.php",
            "screenshot.png",
        ]);

        for($i = 0; $i < count($archivos); $i++)
        {             
            if(!file_exists($ruta."/".$archivos[$i]))
                $flag = false;
        }
        
        if(!$flag)
        {
            error("El archivo .zip no contiene los archivos necesarios para que el tema funcione, los archivos necesarios son: <br><br>
                <ul>
                    <li>info.xml</li>
                    <li>install.xml</li>
                    <li>index.blade.php</li>
                    <li>master.blade.php</li>
                    <li>carrito.blade.php</li>
                    <li>categoria.blade.php</li>
                    <li>pagina.blade.php</li>
                    <li>producto.blade.php</li>
                    <li>productos.blade.php</li>
                    <li>screenshot.png</li>
                </ul>
            ");

            if(is_dir($ruta))
                eliminar_carpeta($ruta);
            
            return back();

        }

        if(file_exists($ruta."/info.xml"))
            $contenido = simplexml_load_file($ruta."/info.xml");
    
        $tema           = new Tema();
        $tema->nombre   = $contenido->nombre;
        $tema->tipo     = "privado";
        $tema->carpeta  = $nameFile;      
        $tema->precio   = "0";
        $tema->save();

        Auth::user()->empresa->temas()->attach($tema, ['estado' => 'aprobado', 'carpeta' => $nameFile]);

        registro(
            "info",
            usuario(),
            usuario('empresa'),
            "Tema",
            "Cargar",
            "Se cargo un nuevo tema"
        );

        exito("El tema se instalo correctamente");
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $empresa    = Auth::user()->empresa;
        $tema       = $empresa->temas->where('id', $id)->first();

        if($tema == null)
        {
            error('Error al eliminar tema');
            return back();
        }

        Auth::user()->empresa->temas()->detach($tema);

        if(is_dir(resource_path('views/empresas/'.Auth::user()->empresa->id."/".$tema->pivot->carpeta)))
            eliminar_carpeta(resource_path('views/empresas/'.Auth::user()->empresa->id."/".$tema->pivot->carpeta));

        if($tema->tipo == "privado")
            $tema->delete();

        registro(
            "info",
            usuario(),
            usuario('empresa'),
            "Tema",
            "Eliminar",
            "Se elimino un tema"
        );

        exito("El tema se elimino correctamente.");
        return redirect('admin/tema');
    }

    public function instalar($id)
    {
        $tema = Tema::find($id);

        if($tema == null)
        {
            error("Error al instalar el tema");
            return back();
        }

        instalar_tema($id);

        registro(
            "info",
            usuario(),
            usuario('empresa'),
            "Tema",
            "Instalar",
            "Se instalo un nuevo tema"
        );

        exito("El tema se instalo correctamente");
        return back();
    }

    public function activar($id)
    {
        $empresa    = Auth::user()->empresa;
        $tema       = $empresa->temas->where('id', $id)->first();

        if($tema == null)
        {
            error("Error al activar el tema");
            return back();
        }

        if(!$this->comprobar_tema($tema->id))
        {
            error('La empresa no tiene instalado este tema');
            return redirect('admin/tema');
        }

        if(!file_exists(resource_path('views/empresas/'.Auth::user()->empresa->id."/".$tema->pivot->carpeta."/install.xml")))
        {
            error('Error al activar el tema');
            return redirect('admin/tema');
        }
        
        $contenido = simplexml_load_file(
                    resource_path('views/empresas/'.Auth::user()->empresa->id."/".$tema->pivot->carpeta."/install.xml")
                );

        Auth::user()->empresa->landings()->delete();
        
        foreach($contenido as $elemento)
        {
            Landing::create([
                'titulo'        => $elemento->titulo,
                'llave'         => $elemento->llave,
                'valor'         => $elemento->valor,
                'tipo'          => $elemento->tipo,
                'empresa_id'    => Auth::user()->empresa->id
            ]);
        }

        $empresa->carpeta = $tema->pivot->carpeta;
        $empresa->save();

        registro(
            "info",
            usuario(),
            usuario('empresa'),
            "Tema",
            "Activar",
            "Se activa tema"
        );

        exito("El tema ".$tema->nombre." se activo correctamente");
        return back();
    }

    public function reinstalar()
    {
        Auth::user()->empresa->landings()->delete();

        if(!file_exists(resource_path('views/empresas/'.Auth::user()->empresa->id."/".Auth::user()->empresa->carpeta."/install.xml")))
        {
            error('Error al reinstalar tema');
            return redirect('admin/tema');
        }

        $contenido = simplexml_load_file(
                            resource_path('views/empresas/'.Auth::user()->empresa->id."/".Auth::user()->empresa->carpeta."/install.xml")
                        );
        
        foreach($contenido as $elemento)
        {
            Landing::create([
                'titulo'        => $elemento->titulo,
                'llave'         => $elemento->llave,
                'valor'         => $elemento->valor,
                'tipo'          => $elemento->tipo,
                'empresa_id'    => Auth::user()->empresa->id
            ]);
        }

        registro(
            "info",
            usuario(),
            usuario('empresa'),
            "Tema",
            "Reseteo",
            "Se resetea tema"
        );

        exito("El tema se reseteo correctamente.");
        return back();
    }

    public function pago_exitoso(Request $request)
    {
        instalar_tema($request->external_reference);

        registro(
            "info",
            usuario(),
            usuario('empresa'),
            "Tema",
            "Pago exitoso",
            "Se instalo tema"
        );

        exito("El tema ".$tema->nombre." se instalo correctamente");
        return redirect('admin/tema');
    }

    public function pago_fallido(Request $request)
    {
        registro(
            "info",
            usuario(),
            usuario('empresa'),
            "Tema",
            "Pafo fallido",
            "Se rechazo el pago del plugin"
        );

        error("Hubo un error y no pudimos instalar el tema.");
        return redirect('admin/tema');   
    }

    public function pago_pendiente(Request $request)
    {
        $empresa    = Auth::user()->empresa;
        $tema       = Tema::find($request->external_reference);

        if($tema == null)
        {
            error("Error al procesar el pago");
            return redirect('admin/tema');
        }

        $empresa->temas()->attach($tema, ['estado' => 'pendiente', 'mp_id' => $request->payment_id]);
        
        exito("El tema ".$tema->nombre." esta pendiente de instalación hasta que el pago sea aprobado.");
        return redirect('admin/tema'); 
    }

    public function descargar($id)
    {
        $empresa    = Auth::user()->empresa;
        $tema       = $empresa->temas->where('id', $id)->first();

        if(!$this->comprobar_tema($tema->id))
        {
            error("No tienes instalado este tema");
            return redirect('admin/tema');
        }

        $zip        = new ZipFile();
        $nameFile   = public_path("storage/".codigo_aleatorio(10).".zip");
        
        $zip
        ->addDirRecursive(resource_path("views/empresas/".Auth::user()->empresa->id."/".$tema->pivot->carpeta))
        ->saveAsFile($nameFile)
        ->close(); 

        return Response::download($nameFile, $tema->nombre.'.zip');
    }

    private function comprobar_tema($id)
    {
        $empresa = Auth::user()->empresa;
        $flag = false;

        foreach($empresa->temas as $tema)
        {
            if($tema->id == $id)
                $flag = true;
        }

        return $flag;
    }
}
