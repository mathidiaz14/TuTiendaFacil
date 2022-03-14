<?php

namespace App\Models\Ayuda;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AyudaEntrada extends Model
{
    use HasFactory;

    public function categoria()
    {
        return $this->belongsTo('App\Models\Ayuda\AyudaCategoria', 'categoria_id');
    }
}
