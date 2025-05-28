<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Salon extends Model {
    use HasFactory ;
    
    protected $table = 'salon';
    protected $primaryKey = 'id_salon';
    protected $fillable = ['nombre','direccion','telefono','horario_apertura','horario_cierre','descripcion','foto','especializacion','id_usuario'];
    public $timestamps = false;

   public function getFotoUrlAttribute() {
        if ($this->foto) {
            return asset('storage/salones/' . $this->foto); 
        }
        return null; 
    }

    public function usuario()   { return $this->belongsTo(Usuario::class, 'id_usuario');}
    public function empleados() { return $this->hasMany(Empleado::class,'id_salon'); }
    public function servicios() { return $this->hasMany(Servicio::class,'id_salon'); }
    public function reseñas()   { return $this->hasManyThrough(Resena::class, Servicio::class,'id_salon','id_servicio'); }

}
