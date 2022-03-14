<?php

namespace App\Http\Controllers\Plugins\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Plugins\Blog\BlogEntrada;
use App\Models\Plugins\Blog\BlogCategoria;
use App\Models\Plugins\Blog\BlogComentario;
use App\Models\User;
use Carbon\Carbon;

class BlogControladorPrincipal extends Controller
{

    private $empresa;
    private $carpeta;

    public function __construct()
    {
        $this->empresa = empresa();
        
        if($this->empresa != null)
            $this->carpeta = 'empresas.'.$this->empresa->id.".".$this->empresa->carpeta.".";

        if($this->comprobar() != null)
            return $this->comprobar();
    }

    public function index()
    {
        $entradas = empresa()->blogEntradas;
        
        if(view()->exists($this->carpeta."blog.index"))
            return view($this->carpeta."blog.index", compact('entradas'));   

        return $this->error404();
    }
    
    public function entrada($id)
    {
        $entrada   = $this->empresa->blogEntradas->where('url', $id)->first();

        if(($entrada != null) and ($entrada->estado == "activo"))
        {
            if(view()->exists($this->carpeta."blog.entrada"))
                return view($this->carpeta."blog.entrada", compact('entrada'));   
        }
        
        return $this->error404();
    }

    public function categoria($url)
    {
        $categoria = empresa()->blogCategorias->where('url', $url)->first();
        
        if($categoria != null)
        {
            $entradas = $categoria->entradas;

            if(view()->exists($this->carpeta."blog.categoria"))
                return view($this->carpeta."blog.categoria", compact('categoria', 'entradas'));                   
        }

        return $this->error404();
    }

    public function comentario(Request $request, $id)
    {
        $entrada = BlogEntrada::find($id);

        if($entrada == null)
            return $this->error404();

        $comentario                 = new BlogComentario();
        $comentario->entrada_id     = $id;
        $comentario->empresa_id     = $entrada->empresa_id;
        $comentario->user_name      = $request->nombre;
        $comentario->user_email     = $request->email;
        $comentario->contenido      = $request->contenido;
        $comentario->parent_id      = $request->parent_id;
        $comentario->estado         = "pendiente";
        $comentario->save();

        crear_notificacion(
                'Nuevo comentario', 
                'Nuevo comentario en la entrada '.$entrada->titulo,
                'admin/blog/comentario',
                $comentario->empresa_id
            );

        exito("El comentario se envio correctamente, esta pendiente de aprobación");
        return back();
    }

    private function comprobar()
    {
        if($this->empresa == null)
            return view('landing.index');

        if(Carbon::now()->diffInDays($this->empresa->expira, false) <= 0)
            return view('errors.expiro');

        if($this->empresa->configuracion->construccion == "on")
            return view('errors.construccion');
    }

    private function error404()
    {
        if(view()->exists($this->carpeta."404"))
            return view($this->carpeta."404");
        
        return abort(404);
    }
}
