<?php

namespace App\Models\Plugins\Blog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogCategoria extends Model
{
    use HasFactory;

    public function empresa()
    {
        return $this->belongsTo('App\Models\Empresa');
    }

    public function entradas()
    {
        return $this->hasMany('App\Models\Plugins\Blog\BlogEntrada', 'categoria_id');
    }
}
