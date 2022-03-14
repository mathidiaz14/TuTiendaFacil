<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Landing extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'llave',
        'valor',
        'tipo',
        'empresa_id',
    ];

    public function empresa()
    {
        return $this->belongsTo('App\Models\Empresa');
    }
}
