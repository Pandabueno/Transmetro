<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Bus extends Model {
    protected $table = 'buses';
    protected $fillable = ['linea_id', 'parqueo_id', 'placa', 'capacidad_max'];
    public function linea() { return $this->belongsTo(Linea::class); }
    public function parqueo() { return $this->belongsTo(Parqueo::class); }
    public function piloto() { return $this->hasOne(Piloto::class); }
    public function registroEsperas() { return $this->hasMany(RegistroEspera::class); }
}