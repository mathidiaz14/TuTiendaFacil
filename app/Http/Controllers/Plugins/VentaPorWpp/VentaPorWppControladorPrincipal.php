<?php

namespace App\Http\Controllers\Plugins\VentaPorWpp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Plugins\VentaPorWpp\VentaPorWpp;
use Auth;

class VentaPorWppControladorPrincipal extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $wpp = Auth::user()->empresa->ventaPorWpp;

        return view('plugins.VentaPorWpp.index', compact('wpp'));
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
        $wpp                = Auth::user()->empresa->ventaPorWpp;

        if($wpp == null)
            $wpp            = new VentaPorWpp();

        $wpp->empresa_id    = Auth::user()->empresa_id;
        $wpp->telefono      = $request->telefono;
        $wpp->texto         = $request->texto;
        $wpp->save();

        registro(
            "info",
            usuario(),
            usuario('empresa'),
            "WPP",
            "Editar",
            "Se editan datos de wpp"
        );

        exito('Los datos se guardaron correctamente.');
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
        //
    }

    public function venta($id)
    {
        $empresa = empresa();
        $plugin  = $empresa->plugins->where('carpeta', 'VentaPorWpp')->first();

        if(($plugin != null) and ($plugin->pivot->estado == 'activo'))
        {
            $producto   = Producto::find($id);
            $wpp        = $producto->empresa->ventaPorWpp;

            if(($producto != null) and ($wpp != null))
            {
                $nombre     = str_replace(" ", "%20", $producto->nombre);

                $texto      = str_replace("#codigo#", "\"".$producto->id."\"", $wpp->texto);
                $texto      = str_replace("#nombre#", "\"".$nombre."\"", $texto);
                $texto      = str_replace("#precio#", "\"".producto_precio($producto->id)."\"", $texto);

                return redirect("https://wa.me/".$wpp->telefono."?text=".$texto);
            }
        }

        abort('404');
    }

}
