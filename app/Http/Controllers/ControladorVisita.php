<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Visita;
use Carbon\Carbon;
use Auth;
use DB;

class ControladorVisita extends Controller
{
    private $path = "admin.visita.";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $visitas = Visita::where('empresa_id', Auth::user()->empresa_id)
                            ->OrderByDesc('created_at')
                            ->paginate(10);
        
        $date = Visita::where('empresa_id', Auth::user()->empresa_id)
                        ->where('created_at', '>=', \Carbon\Carbon::now()->subDays(10)) 
                        ->groupBy('fecha') 
                        ->orderBy('fecha', 'ASC') 
                        ->get(array(
                                DB::raw('Date(created_at) as fecha'), 
                                DB::raw('COUNT(*) as "views"') 
                            ));

        $city = Visita::where('empresa_id', Auth::user()->empresa_id)
                        ->groupBy('ciudad') 
                        ->orderBy('ciudad', 'ASC') 
                        ->get(array(
                                DB::raw('ciudad as "ciudad"'), 
                                DB::raw('COUNT(*) as "views"') 
                            ));

        $country = Visita::where('empresa_id', Auth::user()->empresa_id)
                        ->groupBy('pais') 
                        ->orderBy('pais', 'ASC') 
                        ->get(array(
                                DB::raw('pais as "pais"'), 
                                DB::raw('COUNT(*) as "views"') 
                            ));    
        
        $path = Visita::where('empresa_id', Auth::user()->empresa_id)
                        ->groupBy('url') 
                        ->orderBy('url', 'DESC') 
                        ->get(array(
                                DB::raw('url as "url"'), 
                                DB::raw('COUNT(*) as "views"') 
                            ));  
        
        for ($i=9; $i >= 0; $i--) 
        { 
            $days[$i][0] = 0;
            
            foreach ($date as $d) 
            {
                if ($d->fecha == \Carbon\Carbon::now()->subDays($i)->format('Y-m-d'))
                    $days[$i][0] = $d->views;
            }

            $days[$i][1] = \Carbon\Carbon::now()->subDays($i)->format('d/m/Y');
        }

        return view($this->path."index", compact('visitas', 'date', 'city', 'country', 'path', 'days'));
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
        switch ($request->desde) {
            case '1':
                
                $visitas = Auth::user()->empresa->visitas->where('created_at', '>=', Carbon::now()->subMonth());

                foreach ($visitas as $visita)
                    $visita->delete();
                
                exito("Se borraron las visitas del ultimo mes");
                break;

            case '3':
                $visitas = Auth::user()->empresa->visitas->where('created_at', '>=', Carbon::now()->subMonths(3));

                foreach ($visitas as $visita)
                    $visita->delete();
                
                exito("Se borraron las visitas de los ultimos 3 meses");
                break;

            case '6':
                $visitas = Auth::user()->empresa->visitas->where('created_at', '>=', Carbon::now()->subMonths(6));

                foreach ($visitas as $visita)
                    $visita->delete();
                
                exito("Se borraron las visitas de los ultimos 6 meses");
                break;

            case '12':
                $visitas = Auth::user()->empresa->visitas->where('created_at', '>=', Carbon::now()->subYear());

                foreach ($visitas as $visita)
                    $visita->delete();
                
                exito("Se borraron las visitas del ultimo año");
                break;

            case 'principio':
                $visitas = Auth::user()->empresa->visitas;

                foreach ($visitas as $visita)
                    $visita->delete();
                
                exito("Se borraron todas las visitas");
                break;
        }

        registro(
            "info",
            usuario(),
            usuario('empresa'),
            "Visita",
            "Eliminar",
            "Se eliminan visitas"
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
        $visita = Visita::find($id);

        if(($visita == null) or (!control_empresa($visita->empresa_id)))
        {
            error("Error al eliminar la visita");
            return back();
        }

        $visita->delete();
        
        registro(
            "info",
            usuario(),
            usuario('empresa'),
            "Visita",
            "Eliminar",
            "Se elimino visita"
        );

        error("El registro se elimino correctamente");
        return back();
    }
}
