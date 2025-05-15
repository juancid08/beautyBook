<?php

// app/Models/Notificacion.php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model {
    protected $table = 'notificacion';
    protected $primaryKey = 'id_notificacion';
    protected $fillable = ['mensaje','fecha_envio','tipo','estado','id_usuario'];

    public function usuario() { return $this->belongsTo(Usuario::class,'id_usuario'); }
}
