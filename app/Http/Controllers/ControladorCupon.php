<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cupon;
use Auth;

class ControladorCupon extends Controller
{
    private $path = "admin.cupon.";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cupones = Auth::user()->empresa->cupones;

        return view($this->path."index", compact('cupones'));
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
        $old = Auth::user()->empresa->cupones->where('codigo', $request->codigo)->first();

        if($old != null)
        {
            error("El codigo ya existe, prueba con otro");
            return back();
        }

        $cupon              = new Cupon();
        $cupon->codigo      = $request->codigo;
        $cupon->descuento   = $request->descuento;
        $cupon->cantidad    = $request->cantidad;
        $cupon->empresa_id  = usuario('empresa');
        $cupon->save();


        registro(
            "info",
            usuario(),
            usuario('empresa'),
            "Cupón",
            "Crear",
            "Se crea cupón"
        );

        exito("El cupón se creo correctamente");
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
        $cupon              = Cupon::find($id);
        
        if(($cupon == null) or (!control_empresa($cupon->empresa_id)))
        {
            error('Error al modificar el cupon');
            return back();
        }

        $cupon->codigo      = $request->codigo;
        $cupon->descuento   = $request->descuento;
        $cupon->cantidad    = $request->cantidad;
        $cupon->empresa_id  = usuario('empresa');
        $cupon->save();


        registro(
            "info",
            usuario(),
            usuario('empresa'),
            "Cupón",
            "Editar",
            "Se edita cupón"
        );

        exito("El cupón se modifico correctamente");
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
        $cupon = Cupon::find($id);

        if(($cupon == null) or (!control_empresa($cupon->empresa_id)))
        {
            error('No se pudo eliminar el cupón');
            return back();
        }

        $cupon->delete();


        registro(
            "info",
            usuario(),
            usuario('empresa'),
            "Cupón",
            "Eliminar",
            "Se elimna Cupón."
        );

        exito("El cupón se elimino correctamente");
        return back();
    }

    public function cambiar($id)
    {
        $cupon = Cupon::find($id);

        if(!control_empresa($cupon->empresa_id))
        {
            error('Error al cambiar estado de cupón');
            return back();
        }
        
        if($cupon->cantidad == 0)
        {
            error("No se puede cambiar un cupon que este en 0");
            return back();
        }

        if($cupon->estado == "activo")
            $cupon->estado = "inactivo";
        else
            $cupon->estado = "activo";

        $cupon->save();

        registro(
            "info",
            usuario(),
            usuario('empresa'),
            "Cupón",
            "Cambiar",
            "Se cambia estado de cupón"
        );
        
        exito("El cupón cambio de estado");
        return back();

    }   
}
