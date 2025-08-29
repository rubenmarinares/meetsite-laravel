<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    //

    protected $table = 'grupos';


    protected $fillable=[
        'grupo',
        'properties',
        'color',
        'fechainicio',
        'fechafin',
        'textcolor',
        'status',
        'fecha',
    ];

    public static function propertiesDefault()
    {
        return [
            'color' => '#FFFFFF',
            'textcolor' => '#000000',
        ];
    }

    public function academiasRelation(){
        return $this->belongsToMany(Academia::class, 'academias_grupos', 'grupoid', 'academiaid');
    }
   
    //Para eliminar un grupo, eliminamos la relación con las academias
    protected static function boot(){
        parent::boot();
        static::deleting(function ($grupo) {
            $grupo->academiasRelation()->detach();
        });
    }
}