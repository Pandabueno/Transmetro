<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Operador extends Model {
    protected $table = 'operadores';
    protected $fillable = ['estacion_id', 'nombre', 'usuario', 'password', 'rol'];
    protected $hidden = ['password'];
    public function estacion() { return $this->belongsTo(Estacion::class); }
    public function alertasAtendidas() { return $this->hasMany(Alerta::class, 'atendida_por'); }
    public function esAdmin(): bool { return $this->rol === 'admin'; }
    public function esOperador(): bool { return $this->rol === 'operador'; }
    public function esSupervisor(): bool { return $this->rol === 'supervisor'; }
}