<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta;
use MercadoPago;
use Auth;

class ControladorVenta extends Controller
{
    private $path = "admin.venta.";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
         if($request->buscar == null)
        {
            $ventas = Venta::where('empresa_id', Auth::user()->empresa_id)
                            ->where('estado', '!=', 'comenzado')
                            ->paginate(20);
        }else
        {
            $ventas = Venta::where('empresa_id', '=', Auth::user()->empresa_id)
                            ->where('estado', '!=', 'comenzado')
                            ->where(function ($query) use ($request) {
                               $query->where('codigo', '=', $request->buscar)
                                    ->orWhere('cliente_nombre', 'LIKE', '%'.$request->buscar.'%')
                                    ->orWhere('cliente_apellido', 'LIKE', '%'.$request->buscar.'%')
                                    ->orWhere('cliente_telefono', 'LIKE', '%'.$request->buscar.'%')
                                    ->orWhere('cliente_email', 'LIKE', '%'.$request->buscar.'%');
                           })
                           ->get();
        }
        
        return view($this->path."index", compact('ventas'));
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
        $venta = Venta::find($id);

        if(($venta == null) or (!control_empresa($venta->empresa_id)))
        {
            error("Error al mostrar venta");
            return redirect('admin/venta');
        }

        return view($this->path."show", compact('venta'));
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
        $venta  = Venta::find($id);

        if(($venta == null) or (!control_empresa($venta->empresa_id)))
        {
            error("Error al editar venta");
            return redirect('admin/venta');
        }

        $venta->observacion = $request->observacion;
        $venta->save();

        registro(
            "info",
            usuario(),
            usuario('empresa'),
            "Venta",
            "Editar",
            "Se modifico venta"
        );

        exito('Se agrego una observacion');
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
        $venta = Venta::find($id);

        if(($venta == null) or (!control_empresa($venta->empresa_id)))
        {
            error("Error al eliminar la venta");
            return back();
        }

        $venta->delete();

        registro(
            "info",
            usuario(),
            usuario('empresa'),
            "Venta",
            "Eliminar",
            "Se elimino venta"
        );

        exito('El pedido se elimino correctamente');
        return back();
    }

    public function entregar($id)
    {
        $venta = Venta::find($id);

        if(($venta == null) or (!control_empresa($venta->empresa_id)))
        {
            error('Error al entregar producto');
            return back();
        }


        $venta->estado = "entregado";
        $venta->save();

        registro(
            "info",
            usuario(),
            usuario('empresa'),
            "Venta",
            "Entrega",
            "Se cambio estado del pedido"
        );

        exito("Se cambio el estado del pedido.");
        return back();
    }

    public function devolver($id)
    {
        $venta = Venta::find($id);

        if(($venta == null) or (!control_empresa($venta->empresa_id)))
        {
            error('Error al cambiar el estado de la venta');
            return back();
        }

        if(($venta->estado == "aprobado") or ($venta->estado == "entregado"))
        {
            MercadoPago\SDK::configure(['ACCESS_TOKEN' => $venta->empresa->configuracion->mp_access_token]);
            $payment = MercadoPago\Payment::find_by_id($venta->mp_id);
            $payment->refund();

            $venta->estado = "devuelto";
            $venta->save();

            registro(
                "info",
                usuario(),
                usuario('empresa'),
                "Venta",
                "Devolver",
                "Se cambio estado del pedido"
            );

            exito("Se cambio el estado del pedido.");
            return back();
        }

        error('Error al cambiar el estado de la venta');
        return back();
    }

    public function cancelar($id)
    {
        $venta = Venta::find($id);

        if(($venta == null) or (!control_empresa($venta->empresa_id)))
        {
            error('Error al cambiar el estado de la venta');
            return back();
        }

        if(($venta->estado == "pendiente") or ($venta->estado == "en_proceso"))
        {
            MercadoPago\SDK::configure(['ACCESS_TOKEN' => $venta->empresa->configuracion->mp_access_token]);
            
            $payment            = MercadoPago\Payment::find_by_id($venta->mp_id);
            $payment->status    = "cancelled";
            $payment->update();


            $venta->estado = "cancelado";
            $venta->save();

            registro(
                "info",
                usuario(),
                usuario('empresa'),
                "Venta",
                "Cancelar",
                "Se cambio estado del pedido"
            );

            exito("Se cambio el estado del pedido.");
            return back();
        }

        error('Error al cambiar el estado de la venta');
        return back();
    }
}
