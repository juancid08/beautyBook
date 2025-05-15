<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Cita extends Model {
    protected $table = 'cita';
    protected $primaryKey = 'id_cita';
    protected $fillable = ['fecha','hora','estado','id_usuario','id_servicio','id_empleado'];

    public function usuario()  { return $this->belongsTo(Usuario::class,'id_usuario'); }
    public function servicio() { return $this->belongsTo(Servicio::class,'id_servicio'); }
    public function empleado() { return $this->belongsTo(Empleado::class,'id_empleado'); }
    public function pago()     { return $this->hasOne(Pago::class,'id_cita'); }
}

