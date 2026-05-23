<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Municipalidad extends Model {
    protected $table = 'municipalidades';
    protected $fillable = ['nombre', 'departamento', 'telefono'];
    public function lineas() { return $this->hasMany(Linea::class); }
    public function estaciones() { return $this->hasMany(Estacion::class); }
}