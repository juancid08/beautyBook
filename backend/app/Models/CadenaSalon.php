<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CadenaSalon extends Model {
    use HasFactory;
    protected $table = 'cadena_salon';
    protected $primaryKey = 'id_cadena_salon';
    protected $fillable = ['nombre','direccion_central','telefono','correo_contacto','website','descripcion'];
    public $timestamps = false;

    public function salones() {
        return $this->hasMany(Salon::class,'id_cadena_salon');
    }
}
