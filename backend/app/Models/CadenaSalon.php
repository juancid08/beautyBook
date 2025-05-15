<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class CadenaSalon extends Model {
    protected $table = 'cadena_salon';
    protected $primaryKey = 'id_cadena_salon';
    protected $fillable = ['nombre','direccion_central','telefono','correo_contacto','website','descripcion'];

    public function salones() {
        return $this->hasMany(Salon::class,'id_cadena_salon');
    }
}
