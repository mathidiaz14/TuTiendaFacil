<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresa;
use Http;
use Auth;

class ControladorMercadoPago extends Controller
{
    public function conexion(Request $request)
    {
        if(env('APP_ENV') == "local")
        {
            Http::fake([
                'https://api.mercadopago.com/oauth/token' => Http::response([
                    "access_token"  => "MARKETPLACE_SELLER_TOKEN",
                    "public_key"    => "PUBLIC_KEY",
                    "token_type"    => "bearer",
                    "user_ud"       => "USER_ID",
                    "expires_in"    => 15552000,
                    "scope"         => "offline_access read write",
                    "refresh_token" => "TG-XXXXXXXX"

                ], 200, ['Headers']),

            ]);
        }

        $response = Http::post('https://api.mercadopago.com/oauth/token', [
            'grant_type' => "authorization_code", 
            'client_secret' => env('MP_CLIENT_SECRET'),
            'client_id' => "7882233477752920", 
            'code' => $request->code,
            'redirect_uri' => env("MP_REDIRECT_URI")
        ]);
        
        $empresa                            = Empresa::find($request->state);
        $configuracion                      = $empresa->configuracion;
        
        if($configuracion == null)
        {
            error('No se pudo guardar la configuración;');
            return back();
        }

        $configuracion->mp_estado           = "conectado";
        $configuracion->mp_access_token 	= $response->json()['access_token'];
        $configuracion->mp_public_key       = $response->json()['public_key'];
        $configuracion->mp_refresh_token 	= $response->json()['refresh_token'];
        $configuracion->mp_user_id          = $response->json()['user_id'];
        $configuracion->mp_expires_in 	    = $response->json()['expires_in'];
        $configuracion->save();

        registro(
            "info",
            usuario(),
            usuario('empresa'),
            "MercadoPago",
            "Conexion",
            "Se conecto con MercadoPago"
        );

        exito("Se conecto correctamente con MercadoPago.com");

        return redirect("/admin/configuracion");
    }

    public function renovar(Request $request)
    {
		if(env('APP_ENV') == "local")
        {
            Http::fake([
    			'https://api.mercadopago.com/oauth/token*' => Http::response([
    			    "access_token" 	=> "MARKETPLACE_SELLER_TOKEN",
    			    "token_type" 	=> "bearer",
    			    "expires_in" 	=> 15552000,
    			    "scope" 		=> "offline_access read write",
    			    "refresh_token" => "TG-XXXXXXXX"

    			], 200, ['Headers']),
    		]);
        }  

        $empresa 					= Empresa::find($request->empresa_id);
        		
		$response = Http::post('https://api.mercadopago.com/oauth/token', [
            'grant_type' => "refresh_token", 
            'client_secret' => env('MP_CLIENT_SECRET'),
            'client_id' => env('MP_CLIENT_ID'), 
            'refresh_token' => $empresa->mp_refresh_token
        ]);
        
        $configuracion                      = $empresa->configuracion;

        $configuracion->mp_access_token     = $response->json()['access_token'];
        $configuracion->mp_public_key       = $response->json()['public_key'];
        $configuracion->mp_refresh_token    = $response->json()['refresh_token'];
        $configuracion->mp_user_id          = $response->json()['user_id'];
        $configuracion->mp_expires_in       = $response->json()['expires_in'];


        registro(
            "info",
            usuario(),
            usuario('empresa'),
            "MercadoPago",
            "Renovación",
            "Se renovo la conexion con MercadoPago"
        );

        return "Se refresco el token de la empresa ".$empresa->nombre;
    }

    public function IPN(Request $request)
    {
        return \Response::make('message', 200);  
    }

    public function desconexion()
    {
        $configuracion = Auth::user()->empresa->configuracion;

        if($configuracion == null)
        {
            error('No se pudo realizar la desconexion');
            return back();
        }

        $configuracion->mp_estado           = null;
        $configuracion->mp_access_token     = null;
        $configuracion->mp_public_key       = null;
        $configuracion->mp_refresh_token    = null;
        $configuracion->mp_user_id          = null;
        $configuracion->mp_expires_in       = null;

        $configuracion->save();


        registro(
            "info",
            usuario(),
            usuario('empresa'),
            "MercadoPago",
            "Desconexion",
            "Se desconecto con MercadoPago"
        );

        exito("La desconexion se realizo correctamente");

        return back();
    }
}
