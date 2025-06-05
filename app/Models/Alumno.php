<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    /** @use HasFactory<\Database\Factories\AlumnosFactory> */
    use HasFactory;

    protected $table = 'alumnos';


    protected $fillable=[
        'nombre',
        'status',
        'apellidos',
        'email',
    ];

    public function academiasRelation(){                
        return $this->belongsToMany(Academia::class, 'academias_alumnos', 'alumnoid', 'academiaid');
    }
    



    //Para eliminar un profesor, eliminamos la relación con las academias
    protected static function boot(){
        parent::boot();
        static::deleting(function ($alumno) {
            $alumno->academiasRelation()->detach();
        });
    }
}
