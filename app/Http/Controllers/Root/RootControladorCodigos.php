<?php

namespace App\Http\Controllers\Root;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Codigo;

class RootControladorCodigos extends Controller
{
    private $path = "root.codigo.";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $codigos = Codigo::paginate(20);

        return view($this->path."index", compact('codigos'));
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
        $old = Codigo::where('codigo', $request->codigo)->first();

        if($old != null)
        {
            Session(['error' => "Ese codigo ya esta utilizado"]);
            return back()->withInput();
        }

        $codigo             = new Codigo();
        $codigo->codigo     = $request->codigo;
        $codigo->tipo       = $request->tipo;
        $codigo->descuento  = $request->descuento;
        $codigo->cantidad   = $request->cantidad;
        $codigo->email      = $request->email;
        $codigo->save();

        Session(["exito" => "El codigo se creo correctamente"]);
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
        $codigo = Codigo::find($id);
        $codigo->delete();

        Session(["exito" => "El codigo se elimino correctamente"]);
        return back();
    }
}
