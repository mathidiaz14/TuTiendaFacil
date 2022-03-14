<?php

namespace App\Http\Controllers\Ayuda;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ayuda\AyudaCategoria;
use App\Models\Ayuda\AyudaEntrada;

class ControladorAyudaPrincipal extends Controller
{
    private $path = "help.";

    public function index()
    {
        $categorias = AyudaCategoria::where('parent_id', null)->get();

        return view($this->path."index", compact('categorias'));
    }

    public function entrada($id)
    {
        $entrada = AyudaEntrada::find($id);

        if($entrada->estado == "activo")
            return view($this->path."entrada", compact('entrada'));

        return redirect('ayuda');

    }

    public function categoria($id)
    {
        $categoria = AyudaCategoria::find($id); 
        $categorias = $categoria->hijos;

        $entradas = $categoria->entradas->where('estado', 'activo');

        return view($this->path."categoria", compact('categoria', 'categorias', 'entradas'));
    }

    public function buscar(Request $request)
    {
        $entradas = AyudaEntrada::where('estado', 'activo')
                                ->where(function ($query) use ($request) {
                                   $query->where('titulo', 'LIKE', '%'.$request->busqueda.'%')
                                        ->orWhere('contenido', 'LIKE', '%'.$request->busqueda.'%');
                               })
                               ->get();

        return view($this->path."buscar", compact('entradas'));
    }
}
