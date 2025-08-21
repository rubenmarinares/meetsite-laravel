<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aula extends Model
{
    /** @use HasFactory<\Database\Factories\AulaFactory> */
    use HasFactory;

    protected $table = 'aulas';


    protected $fillable=[
        'aula',
        'status',
        'properties',        
    ];



    public static function propertiesDefault()
    {
        return [
            'capacidad' => '',
        ];
    }

    public function academiasRelation(){                
        return $this->belongsToMany(Academia::class, 'academias_aulas', 'aulaid', 'academiaid');
    }
    



    //Para eliminar un profesor, eliminamos la relación con las academias
    protected static function boot(){
        parent::boot();
        static::deleting(function ($asignatura) {
            $asignatura->academiasRelation()->detach();
        });
    }
}
