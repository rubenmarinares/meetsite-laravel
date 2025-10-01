<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    protected $table = 'asistencias';

    // Desactivamos incremento automático porque no hay campo "id"
    public $incrementing = false;

    // Si usas clave primaria compuesta (grupoid, alumnoid, fecha), Eloquent no las maneja de forma nativa.
    // Puedes dejar la PK "sin definir" y trabajar con save/update/delete mediante query builder
    // o usar un paquete externo como "eloquent-composite-primary-key".
    protected $primaryKey = ['grupoid', 'alumnoid', 'fecha'];


    protected $fillable = [
        'grupoid',
        'alumnoid',
        'fecha',
        'properties',
        'estado',
    ];
     

    // Sobrescribe el método para que Eloquent pueda usar claves compuestas
    public function setKeysForSaveQuery($query)
    {
        return $query->where('grupoid', $this->getAttribute('grupoid'))
                     ->where('alumnoid', $this->getAttribute('alumnoid'))
                     ->where('fecha', $this->getAttribute('fecha'));
    }
    
    protected $casts = [
        'grupoid'  => 'integer',
        'alumnoid' => 'integer',
        'fecha'    => 'integer',  // Muy importante
        'estado'   => 'integer',
    ];


    // Relaciones
    public function grupo()
    {
        return $this->belongsTo(Grupo::class, 'grupoid');
    }

    public function alumno()
    {
        return $this->belongsTo(Alumno::class, 'alumnoid');
    }
}