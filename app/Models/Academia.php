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

    public function asignaturas(){
        return $this->belongsToMany(Asignatura::class,'academias_asignaturas','academiaid','asignaturaid');
    }

    public function aulas(){
        return $this->belongsToMany(Aula::class,'academias_aulas','academiaid','aulaid');
    }

    public function clientes(){
        return $this->belongsToMany(Aula::class,'academias_clientes','academiaid','clienteid');
    }


    //Para eliminar una academia, eliminamos la relación con los usuarios
    protected static function boot(){
        parent::boot();
        static::deleting(function ($academia) {
            $academia->users()->detach();
            $academia->profesores()->detach();
            $academia->alumnos()->detach();
            $academia->asignaturas()->detach();
            $academia->aulas()->detach();
            $academia->clientes()->detach();
        });
        
    }



}