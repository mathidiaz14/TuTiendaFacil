<?php

namespace App\Models\Plugins\Blog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogEntrada extends Model
{
    use HasFactory;

    public function empresa()
    {
        return $this->belongsTo('App\Models\Empresa');
    }

    public function categoria()
    {
        return $this->belongsTo('App\Models\Plugins\Blog\BlogCategoria');
    }

    public function comentarios()
    {
        return $this->hasMany('App\Models\Plugins\Blog\BlogComentario', 'entrada_id');
    }

    public function usuario()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function registros()
    {
        return $this->hasMany('App\Models\Plugins\Blog\BlogEntradaRegistro', 'entrada_id');
    }
}
