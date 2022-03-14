<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proveedor;
use App\Models\Producto;
use Auth;

class ControladorProveedor extends Controller
{
    private $path = "admin.proveedor.";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $proveedores = Auth::user()->empresa->proveedores;

        return view($this->path."index", compact('proveedores'));
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
        $proveedor              = new Proveedor();
        $proveedor->nombre      = $request->nombre;
        $proveedor->rut         = $request->rut;
        $proveedor->telefono    = $request->telefono;
        $proveedor->email       = $request->email;
        $proveedor->direccion   = $request->direccion;
        $proveedor->observacion = $request->observacion;
        $proveedor->empresa_id  = usuario();
        $proveedor->save();

        registro(
            "info",
            usuario(),
            usuario('empresa'),
            "Proveedor",
            "Agregar",
            "Se agrega proveedor"
        );

        exito("El proveedor se creo correctamente.");
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
        $proveedor = Proveedor::find($id);

        if(($proveedor != null) and (!control_empresa($proveedor->empresa_id)))
        {
            error('No se puede mostrar el proveedor');
            return back();
        }

        $productos = Producto::where('proveedor_id', $id)
                            ->paginate(15);
        
        return view($this->path."show", compact('productos', 'proveedor'));
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
        $proveedor              = Proveedor::find($id);
     
        if(($proveedor == null) or (!control_empresa($proveedor->empresa_id)))
        {
            error('Error al modificar registro');
            return back();
        }

        $proveedor->nombre      = $request->nombre;
        $proveedor->rut         = $request->rut;
        $proveedor->telefono    = $request->telefono;
        $proveedor->email       = $request->email;
        $proveedor->direccion   = $request->direccion;
        $proveedor->observacion = $request->observacion;
        $proveedor->save();

        registro(
            "info",
            usuario(),
            usuario('empresa'),
            "Proveedor",
            "Modificar",
            "Se modifica proveedor"
        );

        exito("El proveedor se modifico correctamente.");
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
        $proveedor = Proveedor::find($id);

        if(($proveedor == null) or (!control_empresa($proveedor->empresa_id)))
        {
            error('No se puede eliminar registro');
            return back();
        }

        foreach($proveedor->productos as $producto)
        {
            $producto->proveedor_id = null;
            $producto->save();
        }

        $proveedor->delete();

        registro(
            "info",
            usuario(),
            usuario('empresa'),
            "Proveedor",
            "Elimnar",
            "Se elimina proveedor"
        );

        exito("El proveedor se borro correctamente.");
        return back();       
    }
}

