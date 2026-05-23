<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class LineaEstacion extends Model {
    protected $table = 'linea_estacion';
    protected $fillable = ['linea_id', 'estacion_id', 'orden', 'distancia'];
    public function linea() { return $this->belongsTo(Linea::class); }
    public function estacion() { return $this->belongsTo(Estacion::class); }
}