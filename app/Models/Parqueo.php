<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Parqueo extends Model {
    protected $table = 'parqueos';
    protected $fillable = ['estacion_id', 'nombre', 'capacidad'];
    public function estacion() { return $this->belongsTo(Estacion::class); }
    public function buses() { return $this->hasMany(Bus::class); }
}