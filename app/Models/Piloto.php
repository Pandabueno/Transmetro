<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Piloto extends Model {
    protected $table = 'pilotos';
    protected $fillable = ['bus_id', 'nombre', 'direccion', 'telefono', 'email'];
    public function bus() { return $this->belongsTo(Bus::class); }
    public function historialEducativo() { return $this->hasMany(HistorialEducativo::class); }
}