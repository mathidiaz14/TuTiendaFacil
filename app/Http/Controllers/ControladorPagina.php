<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pagina;
use Auth;
use Storage;
use File;

class ControladorPagina extends Controller
{
    private $path = "admin.pagina.";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paginas = Auth::user()->empresa->paginas;

        return view($this->path."index", compact('paginas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view($this->path."create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $vieja = Auth::user()->empresa->paginas->where('url', $request->url)->first();;

        if($vieja != null)
        {
            error("Ya hay una pagina con la misma url.");
            return back()->withInput($request->all());
        }

        $file       = $request->file('imagen');
        
        $pagina = new Pagina();

        if($file != null)
        {
            $name       = $file->getClientOriginalName();
            $nameFile   = codigo_aleatorio(10);

            Storage::disk('public')->put($nameFile.".".$file->getClientOriginalExtension(), File::get($file));

            $pagina->imagen = "storage/".$nameFile.".".$file->getClientOriginalExtension();
        }

        $pagina->empresa_id     = usuario('empresa');
        $pagina->titulo         = $request->titulo;
        $pagina->url            = $request->url;
        $pagina->contenido      = $request->contenido;
        $pagina->tipo           = $request->tipo;
        $pagina->save();

        registro(
            "info",
            usuario(),
            usuario('empresa'),
            "Pagina",
            "Agregar",
            "Se agrego una pagina"
        );

        exito('La pagina se creo correctamente');

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
        return redirect('admin/pagina');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pagina = Pagina::find($id);
        
        if(($pagina == null) or (!control_empresa($pagina->empresa_id)))
        {
            error('Error al editar la pagina');
            return back();
        }

        return view($this->path."edit", compact('pagina'));
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
        $vieja  = Auth::user()->empresa->paginas->where('url', $request->url)->first();;
        $file   = $request->file('imagen');
        $pagina = Pagina::find($id);

        if(($vieja != null) and ($vieja->id != $pagina->id))
        {
            error("Ya existe una pagina con la misma URL");
            return back()->withInput($request->all());
        }

        if(($pagina == null) or (!control_empresa($pagina->empresa_id)))
        {
            error('Error al actualizar la pagina');
            return back();
        }

        if($file != null)
        {
            if($pagina->imagen != null)
                unlink($pagina->imagen);

            $name       = $file->getClientOriginalName();
            $nameFile   = codigo_aleatorio(10);

            Storage::disk('public')->put($nameFile.".".$file->getClientOriginalExtension(), File::get($file));

            $pagina->imagen = "storage/".$nameFile.".".$file->getClientOriginalExtension();
        }

        $pagina->titulo     = $request->titulo;
        $pagina->url        = $request->url;
        $pagina->contenido  = $request->contenido;
        $pagina->tipo       = $request->tipo;
        $pagina->save();

        registro(
            "info",
            usuario(),
            usuario('empresa'),
            "Pagina",
            "Editar",
            "Se edito una pagina"
        );

        exito('La pagina se modifico correctamente');

        return redirect('admin/pagina');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pagina = Pagina::find($id);

        if(($pagina == null) or (!control_empresa($pagina->empresa_id)))
        {
            error('Error al eliminar pagina');
            return back();
        }
        
        if(file_exists($pagina->imagen))
            unlink($pagina->imagen);

        $pagina->delete();

        registro(
            "info",
            usuario(),
            usuario('empresa'),
            "Pagina",
            "Eliminar",
            "Se elimino una pagina"
        );

        exito('La pagina se elimino correctamente');
        return back();
    }

    public function eliminar_imagen($id)
    {
        $pagina = Pagina::find($id);
        
        if(($pagina == null) or (!control_empresa($pagina->empresa_id)))
        {
            error('Error al elimnar imagen de pagina');
            return back();
        }

        if(file_exists($pagina->imagen))
            unlink($pagina->imagen);

        $pagina->imagen = null;
        $pagina->save();

        registro(
            "info",
            usuario(),
            usuario('empresa'),
            "Pagina",
            "Eliminar imagen",
            "Se elimina imagen de una pagina"
        );

        exito("La imagen se elimino correctamente");
        return back();
    }
}
