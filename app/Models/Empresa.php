<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    protected $dates = ["expira"];

    public function productos()
    {
        return $this->hasMany('App\Models\Producto');
    }

    public function clientes()
    {
        return $this->hasMany('App\Models\Cliente');
    }

    public function categorias()
    {
        return $this->hasMany('App\Models\Categoria');
    }

    public function proveedores()
    {
        return $this->hasMany('App\Models\Proveedor');
    }

    public function ventas()
    {
        return $this->hasMany('App\Models\Venta');
    }

    public function configuracion()
    {
        return $this->hasOne('App\Models\Configuracion');
    }

    public function multimedia()
    {
        return $this->hasMany('App\Models\Multimedia');
    }

    public function mensajes()
    {
        return $this->hasMany('App\Models\Mensaje');
    }

    public function notificaciones()
    {
        return $this->hasMany('App\Models\Notificacion');
    }

    public function paginas()
    {
        return $this->hasMany('App\Models\Pagina');
    }

    public function locales()
    {
        return $this->hasMany('App\Models\Local');
    }

    public function usuarios()
    {
        return $this->hasMany('App\Models\User');
    }

    public function visitas()
    {
        return $this->hasMany('App\Models\Visita');
    }

    public function landings()
    {
        return $this->hasMany('App\Models\Landing');
    }

    public function plugins()
    {
        return $this->belongsToMany('App\Models\Plugin')->withPivot('estado', 'created_at');
    }

    public function temas()
    {
        return $this->belongsToMany('App\Models\Tema')->withPivot('estado', 'carpeta');
    }

    public function newsletters()
    {
        return $this->hasMany('App\Models\Newsletter');
    }

    public function errores()
    {
        return $this->hasMany('App\Models\Error');
    }

    public function cupones()
    {
        return $this->hasMany('App\Models\Cupon');
    }

    public function registros()
    {
        return $this->hasMany('App\Models\Log');
    }

    /***************************************/

    public function blogCategorias()
    {
        return $this->hasMany('App\Models\Plugins\Blog\BlogCategoria');
    }

    public function blogComentarios()
    {
        return $this->hasMany('App\Models\Plugins\Blog\BlogComentario');
    }

    public function blogEntradas()
    {
        return $this->hasMany('App\Models\Plugins\Blog\BlogEntrada');
    }

    /*************************************/
    
    public function ventaPorWpp()
    {
        return $this->hasOne('App\Models\Plugins\VentaPorWpp\VentaPorWpp');
    }    
}
