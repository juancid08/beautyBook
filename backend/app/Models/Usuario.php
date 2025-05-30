<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Usuario extends Authenticatable
{
    use HasApiTokens, HasFactory;

    protected $table = 'usuario';
    protected $primaryKey = 'id_usuario';

    protected $fillable = [
        'nombre',
        'apellidos',
        'email',
        'password',
        'telefono',
        'rol',
        'foto_perfil'
    ];

    protected $hidden = ['password'];
    public $timestamps = false;

    public function salones()       { return $this->hasMany(Salon::class, 'id_usuario');}
    public function citas()         { return $this->hasMany(Cita::class, 'id_usuario'); }
    public function reseñas()       { return $this->hasMany(Resena::class, 'id_usuario'); }
    public function notificaciones(){ return $this->hasMany(Notificacion::class, 'id_usuario'); }
}
