<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Usuario extends Authenticatable {
    use HasApiTokens;
    protected $table = 'usuario';
    protected $primaryKey = 'id_usuario';
    protected $fillable = ['name','surname','email','password'];
    protected $hidden = ['password'];

    public function citas()     { return $this->hasMany(Cita::class,'id_usuario'); }
    public function reseñas()   { return $this->hasMany(Resena::class,'id_usuario'); }
    public function notificaciones() { return $this->hasMany(Notificacion::class,'id_usuario'); }
}

