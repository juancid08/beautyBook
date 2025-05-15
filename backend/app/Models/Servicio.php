<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Servicio extends Model {
    protected $table = 'servicio';
    protected $primaryKey = 'id_servicio';
    protected $fillable = ['nombre','descripcion','precio','duracion','id_salon'];

    public function salon()   { return $this->belongsTo(Salon::class,'id_salon'); }
    public function citas()   { return $this->hasMany(Cita::class,'id_servicio'); }
    public function reseñas() { return $this->hasMany(Resena::class,'id_servicio'); }
}
