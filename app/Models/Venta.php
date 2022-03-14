<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    public function empresa()
    {
        return $this->belongsTo('App\Models\Empresa');
    }

    public function cliente()
    {
        return $this->belongsTo('App\Models\Cliente');
    }

    public function usuario()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function productos()
    {
        return $this->belongsToMany('App\Models\Producto')->withPivot('cantidad', 'precio', 'variante_id');
    }

    public function local()
    {
        return $this->belongsTo('App\Models\Local');
    }
}
