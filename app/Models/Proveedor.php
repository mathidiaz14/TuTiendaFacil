<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;

    public function empresa()
    {
        return $this->belongsTo('App\Models\Empresa');
    }

    public function productos()
    {
    	return $this->hasMany('App\Models\Producto');
    }
}
