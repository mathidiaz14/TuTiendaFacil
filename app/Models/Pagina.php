<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pagina extends Model
{
    use HasFactory;

    public function empresa()
    {
        return $this->belongsTo('App\Models\Empresa');
    }

    public function multimedia()
    {
        return $this->belongsTo('App\Models\Multimedia');
    }
}
