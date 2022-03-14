<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MensajeError extends Model
{
    use HasFactory;

    public function error()
    {
        return $this->belongsTo('App\Models\Error');
    }

    public function usuario()
    {
        return $this->belongsTo('App\Models\User');
    }
}
