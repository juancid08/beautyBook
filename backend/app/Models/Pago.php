<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model {
    protected $table = 'pago';
    protected $primaryKey = 'id_pago';
    protected $fillable = ['monto','metodo_pago','estado_pago','id_cita'];

    public function cita() { return $this->belongsTo(Cita::class,'id_cita'); }
}
