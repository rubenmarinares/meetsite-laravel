<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asignatura extends Model
{
    /** @use HasFactory<\Database\Factories\AsignaturaFactory> */
    use HasFactory;
    protected $table = 'asignaturas';


    protected $fillable=[
        'asignatura',
        'status',
        'descripcion',        
    ];




    public function academiasRelation(){                
        return $this->belongsToMany(Academia::class, 'academias_asignaturas', 'asignaturaid', 'academiaid');
    }
    



    //Para eliminar un profesor, eliminamos la relación con las academias
    protected static function boot(){
        parent::boot();
        static::deleting(function ($asignatura) {
            $asignatura->academiasRelation()->detach();
        });
    }
}
