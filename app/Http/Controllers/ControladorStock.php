<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\Producto;

class ControladorStock extends Controller
{
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
        $producto = Producto::find($request->producto);

        if($producto == null)
            return false;

        $variante               = new Stock();
        $variante->producto_id  = $request->producto;
        $variante->sku          = $request->sku;
        $variante->nombre       = $request->nombre;
        $variante->cantidad     = $request->cantidad;
        $variante->save();

        registro(
            "info",
            usuario(),
            usuario('empresa'),
            "Stock",
            "Agregar",
            "Se agrego variante de stock al producto ".$producto->id
        );

        return true;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $producto   = Producto::find($id);

        if($producto == null)
        {
            error("Error al mostrar el registro");
            return back();
        }

        $variantes  = $producto->variantes;

        return view('admin.variantes.index', compact('variantes'));
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
        $variante           = Stock::find($id);
     
        if($variante == null)
            return false;

        $variante->sku      = $request->sku;
        $variante->nombre   = $request->nombre;
        $variante->cantidad = $request->cantidad;
        $variante->save();

        registro(
            "info",
            usuario(),
            usuario('empresa'),
            "Stock",
            "Modificar",
            "Se modifico variante de stock"
        );

        return true;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $variante = Stock::find($id);

        if($variante == null)
            return false;

        $variante->delete();

        registro(
            "info",
            usuario(),
            usuario('empresa'),
            "Stock",
            "Eliminar",
            "Se elimino variante de stock"
        );

        return true;
    }
}
