<?php

namespace App\Http\Controllers\Root;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Error;

class RootControladorError extends Controller
{
    private $path = "root.error.";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $errores = Error::paginate(20);

        return view($this->path."index", compact('errores'));
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
        $error = Error::find($id);

        return view($this->path."show", compact('error'));
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
        $error = Error::find($id);
        $error->mensajes()->delete();
        $error->delete();

        session(['error' => "El error se elimino correctamente"]);
        return back();
    }

    public function captura($id)
    {
        $error = Error::find($id);

        if($error->captura != null)
            return view($this->path."captura", compact('error'));

        return back();
    }

    public function tomar($id)
    {
        $error = Error::find($id);

        if($error->estado == "pendiente")
        {
            $error->estado = "tomado";
            $error->save();
        }

        return redirect('root/error/'.$error->id);
    }

    public function resolver($id)
    {
        $error = Error::find($id);

        if($error->estado == "tomado")
        {
            $error->estado = "resuelto";
            $error->save();
        }

        return redirect('root/error/'.$error->id);
    }

    public function reabrir($id)
    {
        $error = Error::find($id);

        if($error->estado == "resuelto")
        {
            $error->estado = "pendiente";
            $error->save();
        }

        return redirect('root/error/'.$error->id);
    }
}
