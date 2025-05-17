<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Resena extends Model {
    use HasFactory ;
    
    protected $table = 'resena';
    protected $primaryKey = 'id_resena';
    public $timestamps = false;
    protected $fillable = ['comentario','calificacion','fecha_resena','id_usuario','id_servicio'];

    public function usuario()  { return $this->belongsTo(Usuario::class,'id_usuario'); }
    public function servicio() { return $this->belongsTo(Servicio::class,'id_servicio'); }
}

