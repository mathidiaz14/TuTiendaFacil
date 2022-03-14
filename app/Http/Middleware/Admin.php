<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
use View;

class Admin
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
        {
            if(Auth::user()->tipo == "admin")
            {
                if(Auth::user()->empresa->estado == "deshabilitado")
                    return response()->view('auth.empresa_deshabilitada');
                
                if(Auth::user()->empresa->estado == "pendiente")
                    return redirect('registrar/pago/online');
                
                if(Auth::user()->empresa->pago == "pendiente")
                    return response()->view('auth.planes.pago_pendiente');

                if(Carbon::now()->diffInDays(Auth::user()->empresa->expira, false) <= 0)
                    return redirect('registrar/expiro');
                
                if(!str_contains(url('/'), "tutiendafacil"))
                    return redirect(env('APP_URL')."/admin");

                return $next($request);

            }elseif(Auth::user()->tipo == "root")
            {
                return redirect('root');
            }
        }
        
        return redirect('login?redirect='.$request->url());
    }
}
