<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Empleado extends Model {
    use HasFactory ;
    
    protected $table = 'empleado';
    protected $primaryKey = 'id_empleado';
    protected $fillable = ['nombre','telefono','foto','id_salon'];
    public $timestamps = false;

    public function salon() { return $this->belongsTo(Salon::class,'id_salon'); }
    public function citas() { return $this->hasMany(Cita::class,'id_empleado'); }
}