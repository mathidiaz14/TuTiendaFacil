<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Local extends Model
{
    use HasFactory;

    public function empresa()
    {
        return $this->belongsTo('App\Models\Empresa');
    }

    public function ventas()
    {
        return $this->hasMany('App\Models\Venta');
    }
}
