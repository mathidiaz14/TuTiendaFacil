<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Newsletter;
use Auth;

class ControladorNewsletter extends Controller
{
    private $path = "admin.newsletter.";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $emails = Newsletter::where('empresa_id', Auth::user()->empresa_id)
                            ->paginate(40);

        return view($this->path."index", compact('emails'));
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
        $old = Auth::user()->empresa->newsletters->where('email', $request->email)->first();
        
        if($old != null)
        {
            error("El email ya esta registrado");
            return back();
        }
     
        $suscriptor = new Newsletter();
        $suscriptor->email = $request->email;
        $suscriptor->empresa_id = Auth::user()->empresa->id;
        $suscriptor->save();

        registro(
            "info",
            usuario(),
            usuario('empresa'),
            "Newsletter",
            "Agregar",
            "Se agrego el suscriptor a la newsletters"
        );

        exito("El suscriptor se creo correctamente");
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
        $old        = Auth::user()->empresa->newsletters->where('email', $request->email)->first();
        $suscriptor = Newsletter::find($id);

        if(($suscriptor == null) or (!control_empresa($suscriptor->empresa_id)) or ($old != null))
        {
            error("El email ya esta registrado");
            return back();
        }

        $suscriptor->email = $request->email;
        $suscriptor->save();

        registro(
            "info",
            usuario(),
            usuario('empresa'),
            "Newsletter",
            "Editar",
            "Se modifico suscriptor"
        );

        exito("El suscriptor se modifico correctamente");
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
        $suscriptor = Newsletter::find($id);

        if(($suscriptor != null) or (!control_empresa($suscriptor->empresa_id)))
        {
            error('Error al eliminar suscriptor');
            return back();
        }

        $suscriptor->delete();

        registro(
            "info",
            usuario(),
            usuario('empresa'),
            "Newsletter",
            "Eliminar",
            "Se elimino el suscriptor"
        );

        exito("El suscriptor se elimino correctamente");
        return back();
    }
}
