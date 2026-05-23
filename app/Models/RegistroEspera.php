<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class RegistroEspera extends Model {
    protected $table = 'registro_esperas';
    protected $fillable = ['bus_id', 'estacion_id', 'fecha_hora', 'minutos_espera'];
    protected $casts = ['fecha_hora' => 'datetime'];
    public function bus() { return $this->belongsTo(Bus::class); }
    public function estacion() { return $this->belongsTo(Estacion::class); }
}