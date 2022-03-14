<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mensaje extends Model
{
    use HasFactory;

    public function empresa()
    {
        return $this->belongsTo('App\Models\Empresa');
    }

    public function padre()
    {
        return $this->belongsTo('App\Models\Mensaje', 'padre_id');
    }

    public function hijos()
    {
        return $this->hasMany('App\Models\Mensaje', 'padre_id');
    }
}
