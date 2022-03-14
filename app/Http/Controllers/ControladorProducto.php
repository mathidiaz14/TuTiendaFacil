<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use Auth;

class ControladorProducto extends Controller
{

    private $path = "admin.producto.";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->buscar == null)
        {
            $productos = Producto::where('empresa_id', '=', Auth::user()->empresa_id)
                                    ->paginate(15);
        }else
        {
            $productos = Producto::where('empresa_id', '=', Auth::user()->empresa_id)
                           ->where(function ($query) use ($request) {
                               $query->where('sku', 'LIKE', '%'.$request->buscar.'%')
                                    ->orWhere('nombre', 'LIKE', '%'.$request->buscar.'%')
                                    ->orWhere('precio', '=', $request->buscar);
                           })
                           ->get();
        }

        return view($this->path."index", compact('productos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $flag = true;

        if((Auth::user()->empresa->plan == "plan1") and (Auth::user()->empresa->productos->count() >= 20))
            $flag = false;
        elseif((Auth::user()->empresa->plan == "plan2") and (Auth::user()->empresa->productos->count() >= 40))
            $flag = false;

        if(!$flag)
        {
            error("Ha llegado al limite de productos que permite su plan, comuniquese con el administrador si quiere aumentar el plan.");
            return back();
        }

        $url = str_replace(" ", "_", strtolower($request->nombre));
        $old = Auth::user()->empresa->productos->where('url',  '=', $url)->first();

        if($old != null)
        {
            error("Ya hay un producto con el mismo nombre");
            return back();
        }

        $producto               = new Producto();
        $producto->nombre       = $request->nombre;
        $producto->url          = $url;
        $producto->precio       = $request->precio;   
        $producto->empresa_id   = Auth::user()->empresa->id;
        $producto->save();

        registro(
            "info",
            usuario(),
            usuario('empresa'),
            "Producto",
            "Agregar",
            "Se agrega producto"
        );

        exito('El producto se creo exitosamente');
        return redirect('admin/producto/'.$producto->id.'/edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

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
        $producto = Producto::find($id);

        if(($producto == null) or (!control_empresa($producto->empresa_id)))
        {
            error('No se puede editar el producto');
            return redirect('admin/producto');
        }

        return view($this->path."edit", compact('producto'));
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
        $producto               = Producto::find($id);

        if(($producto == null) or (!control_empresa($producto->empresa_id)))
        {
            error('Error al actualizar el registro');
        }
        
        if($producto->url != $request->url)
        {
            $old = Auth::user()->empresa->productos->where('url', $request->url)->first();

            if($old != null)
            {
                error("Ya hay un producto con el mismo nombre");
                return back();
            }
        }

        $producto->sku                  = $request->sku;
        $producto->nombre               = $request->nombre;
        $producto->descripcion          = $request->descripcion;
        $producto->precio               = $request->precio;
        $producto->precio_promocion     = $request->precio_promocion;
        $producto->costo                = $request->costo;
        $producto->cantidad             = $request->cantidad;
        $producto->minimo_producto      = $request->minimo_producto;
        $producto->categoria_id         = $request->categoria;
        $producto->proveedor_id         = $request->proveedor;
        $producto->estado               = $request->estado;
        $producto->nuevo                = $request->nuevo;
        $producto->destacado            = $request->destacado;
        $producto->url                  = $request->url;
        $producto->save();

        exito('El producto se modifico correctamente.');
        
        registro(
            "info",
            usuario(),
            usuario('empresa'),
            "Producto",
            "Modificar",
            "Se modifico el producto"
        );

        if($request->continuar == "si")
            return back();

        return redirect('admin/producto');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $producto = Producto::find($id);

        if(($producto == null) or (!control_empresa($producto->empresa_id)))
        {
            error('No se puede eliminar el registro');
            return back();
        }

        foreach($producto->multimedia as $multimedia)
        {
            if(file_exists($multimedia->url))
                unlink($multimedia->url);

            $multimedia->delete();
        }
        
        $producto->delete();

        registro(
            "info",
            usuario(),
            usuario('empresa'),
            "Producto",
            "Eliminar",
            "Se elimina producto"
        );

        exito('El producto se elimino correctamente');
        return back();
    }
}
