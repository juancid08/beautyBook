<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Servicio extends Model {
    use HasFactory ;
    
    protected $table = 'servicio';
    protected $primaryKey = 'id_servicio';
    protected $fillable = ['nombre','descripcion','precio','duracion','id_salon'];
    public $timestamps = false;

    public function salon()   { return $this->belongsTo(Salon::class,'id_salon'); }
    public function citas()   { return $this->hasMany(Cita::class,'id_servicio'); }
    public function reseñas() { return $this->hasMany(Resena::class,'id_servicio'); }
}
