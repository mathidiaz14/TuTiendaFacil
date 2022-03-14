<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plugin;
use Auth;

class ControladorPlugin extends Controller
{
    private $path = "admin.plugin.";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $misPlugins = Auth::user()->empresa->plugins;
        $plugins    = Plugin::all();

        return view($this->path."index", compact('misPlugins', 'plugins'));
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
        //
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
        $plugin = Plugin::find($id);

        if($plugin == null)
        {
            error('Error al eliminar plugin');
            return back();
        }

        Auth::user()->empresa->plugins()->detach($plugin);

        registro(
            "info",
            usuario(),
            usuario('empresa'),
            "Plugin",
            "Eliminar",
            "Se elimina plugin"
        );

        exito("El plugin se desinstalo correctamente.");
        return back();
    }

    public function instalar($id)
    {
        $plugin     = Plugin::find($id);
        
        if($plugin == null)
        {
            error('No se pudo instalar el plugin');
            return back();
        }

        $empresa    = Auth::user()->empresa;

        $empresa->plugins()->attach($plugin, ['estado' => 'instalado']);
        
        registro(
            "info",
            usuario(),
            usuario('empresa'),
            "Plugin",
            "Instalar",
            "Se instalo plugin"
        );

        exito("El plugin se instalo correctamente");        
        return back();
    }

    public function activar($id)
    {
        $plugin     = Plugin::find($id);

        if($plugin == null)
        {
            error('No se pudo activar el plugin');
            return back();
        }

        $empresa    = Auth::user()->empresa;
        
        if(!$this->comprobar_plugin($plugin->id))
        {
            error('La empresa no tiene instalado este plugin');
            return redirect('admin/plugin');
        }

        $empresa->plugins()->detach($plugin);
        $empresa->plugins()->attach($plugin, ['estado' => 'activo']);

        //esta linea ejecuta el archivo install de cada plugin ya que cada uno realiza acciones diferentes al instalarse.
        if(file_exists(resource_path('views/plugins/'.$plugin->carpeta.'/install.php')))
            include(resource_path('views/plugins/'.$plugin->carpeta.'/install.php'));
        
        registro(
            "info",
            usuario(),
            usuario('empresa'),
            "Plugin",
            "Activar",
            "Se activa plugin"
        );

        exito("El plugin ".$plugin->nombre." se activo correctamente");
        return back();    
    }

    public function desactivar($id)
    {
        $plugin     = Plugin::find($id);

        if($plugin == null)
        {
            error('Error al desactivar plugin');
            return back();
        }

        $empresa    = Auth::user()->empresa;

        if(!$this->comprobar_plugin($plugin->id))
        {
            error('La empresa no tiene instalado este plugin');
            return redirect('admin/plugin');
        }

        $empresa->plugins()->detach($plugin);
        $empresa->plugins()->attach($plugin, ['estado' => 'instalado']);
        
        registro(
            "info",
            usuario(),
            usuario('empresa'),
            "Plugin",
            "Desactivar",
            "Se desacriva plugin"
        );

        error("El plugin se desactivo correctamente");
        return back();    
    }

    public function pago_exitoso(Request $request)
    {
        $plugin     = Plugin::find($request->external_reference);

        if($plugin == null)
        {
            error('Error al procesar el pago');
            return back();
        }

        $empresa    = Auth::user()->empresa;
        
        $empresa->plugins()->attach($plugin, ['estado' => 'instalado']);
        
        exito("El plugin se instalo correctamente");
        return back();
    }

    public function pago_fallido(Request $request)
    {
        error("Hubo un error y no pudimos instalar el plugin.");
        return back();   
    }

    public function pago_pendiente(Request $request)
    {
        $plugin     = Plugin::find($request->external_reference);
        $empresa    = Auth::user()->empresa;

        if($plugin == null)
        {
            error('Error al procesar el pago');
            return back();
        }

        $empresa->plugins()->attach($plugin, ['estado' => 'pendiente', 'mp_id' => $request->payment_id]);
        
        exito("El plugin ".$plugin->nombre." esta pendiente de instalación hasta que el pago sea aprobado.");
        return back();   
    }

    private function comprobar_plugin($id)
    {
        $empresa    = Auth::user()->empresa;
        $flag       = false;

        foreach($empresa->plugins as $plugin)
        {
            if($plugin->id == $id)
                $flag = true;
        }

        return $flag;
    } 
}
