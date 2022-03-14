<?php

namespace App\Http\Controllers\Root;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ayuda\AyudaEntrada;
use App\Models\Ayuda\AyudaCategoria;

class RootControladorAyudaEntrada extends Controller
{
    private $path = "root.ayuda.entrada.";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categorias = AyudaCategoria::all();
        return view($this->path."create", compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $entrada                = new AyudaEntrada();
        $entrada->titulo        = $request->titulo;
        $entrada->estado        = $request->estado;
        $entrada->categoria_id  = $request->categoria_id;
        $entrada->contenido     = $request->contenido;
        $entrada->save();

        session(['exito' => 'Se creo la entrada.']);

        return redirect('root/ayuda');
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
        $entrada = AyudaEntrada::find($id);
        $categorias = AyudaCategoria::all();

        return view($this->path."edit", compact('entrada', 'categorias'));
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
        $entrada                = AyudaEntrada::find($id);
        $entrada->titulo        = $request->titulo;
        $entrada->estado        = $request->estado;
        $entrada->categoria_id  = $request->categoria_id;
        $entrada->contenido     = $request->contenido;
        $entrada->save();

        session(['exito' => 'Se edito la entrada.']);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $entrada = AyudaEntrada::find($id);
        $entrada->delete();

        session(['error' => "Se elimino la categoria"]);

        return redirect('root/ayuda');
    }
}
