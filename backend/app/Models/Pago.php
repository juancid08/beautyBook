<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pago extends Model {
    use HasFactory ;
    protected $table = 'pago';
    protected $primaryKey = 'id_pago';
    protected $fillable = ['monto','metodo_pago','estado_pago','id_cita'];
    public $timestamps = false;

    public function cita() { return $this->belongsTo(Cita::class,'id_cita'); }
}
