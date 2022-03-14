<?php

namespace App\Models\Plugins\VentaPorWpp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VentaPorWpp extends Model
{
    use HasFactory;

    public function empresa()
    {
        return $this->hasOne('App\Models\Empresa');
    }
}
