<?php

namespace App\Http\Middleware\Plugins;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Closure;
use Auth;
use View;

class Blog
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

        $plugin = $empresa->plugins->where('carpeta', 'blog')->first();

    	if(($plugin != null) and ($plugin->carpeta == "blog") and ($plugin->pivot->estado == "activo"))
    		return $next($request);
                
        return redirect('/');
    }
}
