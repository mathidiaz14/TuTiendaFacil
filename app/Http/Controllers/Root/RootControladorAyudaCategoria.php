<?php

namespace App\Http\Controllers\Root;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ayuda\AyudaCategoria;

class RootControladorAyudaCategoria extends Controller
{
    private $path = "root.ayuda.";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categorias = AyudaCategoria::all();

        return view($this->path."index", compact('categorias'));
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
        $categoria              = new AyudaCategoria();
        $categoria->titulo      = $request->titulo;
        $categoria->parent_id   = $request->parent_id;
        $categoria->save();

        session(['exito' => 'Se creo categoria']);

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
        $categoria              = AyudaCategoria::find($id);
        $categoria->titulo      = $request->titulo;
        $categoria->parent_id   = $request->parent_id;
        $categoria->save();

        session(['exito' => 'Se modifico la categoria']);

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
        $categoria = AyudaCategoria::find($id);

        if(($categoria->hijos->count() > 0) or ($categoria->entradas->count() > 0))
        {
            session(['error' => 'No se puede borrar una categoria con contenido']);
        }else
        {
            $categoria->delete();
            session(['exito' => 'Se elimino categoria']);
        }

        return back();
    }
}
