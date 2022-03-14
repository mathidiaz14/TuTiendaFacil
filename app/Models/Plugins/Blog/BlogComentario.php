<?php

namespace App\Models\Plugins\Blog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogComentario extends Model
{
    use HasFactory;

    public function empresa()
    {
        return $this->belongsTo('App\Models\Empresa');
    }

    public function entrada()
    {
        return $this->belongsTo('App\Models\Plugins\Blog\BlogEntrada', 'entrada_id');
    }

    public function hijos()
    {
    	return $this->hasMany('App\Models\Plugins\Blog\BlogComentario', 'parent_id');
    }

    public function padre()
    {
    	return $this->belongsTo('App\Models\Plugins\Blog\BlogComentario', 'parent_id');
    }

    public function usuario()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
