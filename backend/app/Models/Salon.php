<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Salon extends Model {
    protected $table = 'salon';
    protected $primaryKey = 'id_salon';
    protected $fillable = ['nombre','direccion','telefono','horario_apertura','horario_cierre','descripcion','foto','id_cadena_salon'];

    public function cadena()    { return $this->belongsTo(CadenaSalon::class,'id_cadena_salon'); }
    public function empleados() { return $this->hasMany(Empleado::class,'id_salon'); }
    public function servicios() { return $this->hasMany(Servicio::class,'id_salon'); }
    public function reseñas()   { return $this->hasManyThrough(Resena::class, Servicio::class,'id_salon','id_servicio'); }
}