<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notificacion extends Model {
    use HasFactory ;
    protected $table = 'notificacion';
    protected $primaryKey = 'id_notificacion';
    protected $fillable = ['mensaje','fecha_envio','tipo','estado','id_usuario'];
    public $timestamps = false;

    public function usuario() { return $this->belongsTo(Usuario::class,'id_usuario'); }
}

