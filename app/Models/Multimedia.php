<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Multimedia extends Model
{
    use HasFactory;

    public function producto()
    {
        return $this->belongsTo('App\Models\Producto');
    }

    public function empresa()
    {
        return $this->belongsTo('App\Models\Empresa');
    }

    public function pagina()
    {
        return $this->hasOne('App\Models\Pagina');
    }
}
