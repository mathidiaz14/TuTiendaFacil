<?php

namespace App\Http\Middleware\Plugins;

use Closure;
use Illuminate\Http\Request;
use Auth;

class VentaPorWpp
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::check())
            $empresa = Auth::user()->empresa;
        else
            $empresa = empresa();

        $plugin = $empresa->plugins->where('carpeta', 'VentaPorWpp')->first();

        if(($plugin != null) and ($plugin->carpeta == "VentaPorWpp") and ($plugin->pivot->estado == "activo"))
            return $next($request);
                
        return redirect('/');
    }
}
