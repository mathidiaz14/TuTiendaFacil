<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    public function empresa()
    {
        return $this->belongsTo('App\Models\Empresa');
    }

    public function categoria()
    {
        return $this->belongsTo('App\Models\Categoria');
    }

    public function proveedor()
    {
        return $this->belongsTo('App\Models\Proveedor');
    }

    public function multimedia()
    {
        return $this->hasMany('App\Models\Multimedia');
    }

    public function ventas()
    {
        return $this->belongToMany('App\Models\Venta')->withPivot('cantidad', 'precio', 'variante_id');
    }

    public function variantes()
    {
        return $this->hasMany('App\Models\Stock');
    }
}
