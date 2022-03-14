<?php

namespace App\Models\Ayuda;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AyudaCategoria extends Model
{
    use HasFactory;

     public function hijos()
    {
        return $this->hasMany('App\Models\Ayuda\AyudaCategoria', 'parent_id');
    }

    public function padre()
    {
        return $this->belongsTo('App\Models\Ayuda\AyudaCategoria', 'parent_id');
    }

    public function entradas()
    {
        return $this->hasMany('App\Models\Ayuda\AyudaEntrada', 'categoria_id');
    }
}
