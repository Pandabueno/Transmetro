<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class HistorialEducativo extends Model {
    protected $table = 'historial_educativo';
    protected $fillable = ['piloto_id', 'institucion', 'titulo', 'anio_graduacion'];
    public function piloto() { return $this->belongsTo(Piloto::class); }
}