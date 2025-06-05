<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Academia extends Model
{
    //
    use HasFactory;


    protected $fillable=[
        'academia',
        'status',
        'fecha',
        'properties',
        'direccion',
        'localidad'
    ];


    public static function tipos()
    {
        return [
            'privada' => 'Privada',
            'publica' => 'Pública',
            'mixta' => 'Mixta',
            'concertada' => 'Concertada',
            'otro' => 'Otro',
        ];
    }

    public static function propertiesDefault()
    {
        return [
            'capacidad' => '',
            'tipo' => ''
        ];
    }


    /*SOLO DEBERÍAMOS VER LOS USUARIOS DE NUESTRAS ACADEMIAS */
    public function users(){
        return $this->belongsToMany(User::class,'academias_users','academiaid','userid');
    }

    public function profesores(){
        return $this->belongsToMany(Profesor::class,'academias_profesores','academiaid','profesorid');
    }
    

    public function alumnos(){
        return $this->belongsToMany(Alumno::class,'academias_alumnos','academiaid','alumnoid');
    }


    //Para eliminar una academia, eliminamos la relación con los usuarios
    protected static function boot(){
        parent::boot();
        static::deleting(function ($academia) {
            $academia->users()->detach();
        });
        //DEspues de eliminar una academia, eliminamos la relación con los profesores
        static::deleting(function ($academia) {
            $academia->profesores()->detach();
        });

        static::deleting(function ($academia) {
            $academia->alumnos()->detach();
        });
    }


    /*public function alumnos(){
        return $this->belongsToMany(Alumno::class,'academias_alumnos','academiaid','alumnoid');
    }*/

}