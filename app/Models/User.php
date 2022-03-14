<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    protected $dates = ["reset_password_expire"];

    public function empresa()
    {
        return $this->belongsTo('App\Models\Empresa', 'empresa_id');
    }

    public function multimedias()
    {
        return $this->hasMany('App\Models\Multimedia');
    }

    public function errores()
    {
        return $this->hasMany('App\Models\Error');
    }

    public function mensajes_error()
    {
        return $this->hasMany('App\Models\MensajeError');
    }

    public function registros()
    {
        return $this->hasMany('App\Models\Log');
    }

    public function blogEntradas()
    {
        return $this->hasMany('App\Models\Plugins\Blog\BlogEntrada');
    }

    public function blogRegistros()
    {
        return $this->hasMany('App\Models\Plugins\Blog\BlogEntradaRegistro');
    }
}
