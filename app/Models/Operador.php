<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Operador extends Authenticatable {
    protected $table = 'operadores';
    protected $fillable = ['estacion_id', 'nombre', 'usuario', 'password', 'rol'];
    protected $hidden = ['password', 'remember_token'];

    public function getAuthIdentifierName(): string { return 'usuario'; }

    public function estacion() { return $this->belongsTo(Estacion::class); }
    public function alertasAtendidas() { return $this->hasMany(Alerta::class, 'atendida_por'); }
    public function esAdmin(): bool { return $this->rol === 'admin'; }
    public function esOperador(): bool { return $this->rol === 'operador'; }
    public function esSupervisor(): bool { return $this->rol === 'supervisor'; }
}