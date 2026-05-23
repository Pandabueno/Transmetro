<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Alerta extends Model {
    protected $table = 'alertas';
    protected $fillable = ['estacion_id', 'tipo', 'fecha_hora', 'atendida', 'atendida_por'];
    protected $casts = ['fecha_hora' => 'datetime', 'atendida' => 'boolean'];
    public function estacion() { return $this->belongsTo(Estacion::class); }
    public function operadorAtencion() { return $this->belongsTo(Operador::class, 'atendida_por'); }
}