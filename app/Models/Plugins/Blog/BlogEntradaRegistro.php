<?php

namespace App\Models\Plugins\Blog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogEntradaRegistro extends Model
{
    use HasFactory;

    public function entrada()
    {
        return $this->belongsTo('App\Models\Plugins\Blog\BlogEntradaRegistro', 'entrada_id');
    }

    public function usuario()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
