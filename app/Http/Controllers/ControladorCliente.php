<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use Auth;
use DB;

class ControladorCliente extends Controller
{
    private $path = "admin.cliente.";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->buscar == null)
        {
            $clientes = Cliente::where('empresa_id', Auth::user()->empresa_id)->paginate(20);
        }else
        {
            $clientes = Cliente::where('empresa_id', '=', Auth::user()->empresa_id)
                           ->where(function ($query) use ($request) {
                               $query->where('nombre', 'LIKE', '%'.$request->buscar.'%')
                                    ->orWhere('apellido', 'LIKE', '%'.$request->buscar.'%')
                                    ->orWhere('telefono', 'LIKE', '%'.$request->buscar.'%')
                                    ->orWhere('email', 'LIKE', '%'.$request->buscar.'%');
                           })
                           ->get();
        }

        return view($this->path."index", compact('clientes'));   
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
        $old = Auth::user()->empresa->clientes->where('email', $request->email)->first();
            
        if($old != null)
        {
            error('El email que ingreso ya esta registrado como cliente.');
            return back();
        }

        $cliente                    = new Cliente();
        $cliente->empresa_id        = Auth::user()->empresa->id;
        $cliente->nombre            = $request->nombre;
        $cliente->apellido          = $request->apellido;
        $cliente->email             = $request->email;
        $cliente->telefono          = $request->telefono;
        $cliente->direccion         = $request->direccion;
        $cliente->ciudad            = $request->ciudad;
        $cliente->apartamento       = $request->apartamento;
        $cliente->fecha_nacimiento  = $request->fecha_nacimiento;
        $cliente->observacion       = $request->observacion;
        $cliente->save();

        exito('El cliente se registro correctamente.');
        
        registro(
            "info",
            usuario(),
            usuario('empresa'),
            "Cliente",
            "Crear",
            "Se crea cliente."
        );

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
        $cliente = Cliente::find($id);

        if(($cliente == null) or (!control_empresa($cliente->empresa_id)))
        {
            error('Error al mostrar el cliente');
            return back();
        }

        return view($this->path."show", compact('cliente'));
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

        $cliente = Cliente::find($id);

        if(($cliente == null) or (!control_empresa($cliente->empresa_id)))
        {
            error('Error al actualizar cliente');
            return back();
        }

        $old = Auth::user()->empresa->clientes->where('email', $request->email)->first();

        if(($old == null) or ($old->id == $cliente->id))
        {
            $cliente->nombre            = $request->nombre;
            $cliente->apellido          = $request->apellido;
            $cliente->email             = $request->email;
            $cliente->telefono          = $request->telefono;
            $cliente->direccion         = $request->direccion;
            $cliente->ciudad            = $request->ciudad;
            $cliente->apartamento       = $request->apartamento;
            $cliente->fecha_nacimiento  = $request->fecha_nacimiento;
            $cliente->observacion       = $request->observacion;
            $cliente->save();

            exito('El cliente se modifico correctamente.');

            registro(
                "info",
                usuario(),
                usuario('empresa'),
                "Cliente",
                "Editar",
                "Se edita cliente."
            );

            return back();
        }
     
        error('El email que ingreso ya esta registrado como cliente.');
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
        $cliente = Cliente::find($id);

        if(!control_empresa($cliente->empresa_id))
        {
            error('Error al eliminar el cliente');
            return back();
        }
        
        foreach($cliente->ventas as $venta)
        {
            $venta->cliente_id == null;
            $venta->save();
        }

        $cliente->delete();
        

        registro(
            "info",
            usuario(),
            usuario('empresa'),
            "Cliente",
            "Eliminar",
            "Se elimina cliente."
        );

        exito("El cliente se elimino correctamente");
        return back();
    }
}
