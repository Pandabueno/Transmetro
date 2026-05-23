<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Linea extends Model {
    protected $table = 'lineas';
    protected $fillable = ['municipalidad_id', 'nombre', 'distancia_total', 'cantidad_buses'];
    public function municipalidad() { return $this->belongsTo(Municipalidad::class); }
    public function estaciones() {
        return $this->belongsToMany(Estacion::class, 'linea_estacion')
            ->withPivot('orden', 'distancia')->orderByPivot('orden');
    }
    public function buses() { return $this->hasMany(Bus::class); }
    public function puedeAgregarBus(): bool {
        $n = $this->estaciones()->count();
        return $n === 0 || $this->buses()->count() < ($n * 2);
    }
    public function cumpleMinimoBuses(): bool {
        $n = $this->estaciones()->count();
        return $n === 0 || $this->buses()->count() >= $n;
    }
}