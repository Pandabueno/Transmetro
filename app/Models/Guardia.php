<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Guardia extends Model {
    protected $table = 'guardias';
    protected $fillable = ['acceso_id', 'nombre', 'telefono'];
    public function acceso() { return $this->belongsTo(Acceso::class); }
}