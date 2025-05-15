<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model {
    protected $table = 'empleado';
    protected $primaryKey = 'id_empleado';
    protected $fillable = ['nombre','telefono','id_salon'];

    public function salon() { return $this->belongsTo(Salon::class,'id_salon'); }
    public function citas() { return $this->hasMany(Cita::class,'id_empleado'); }
}