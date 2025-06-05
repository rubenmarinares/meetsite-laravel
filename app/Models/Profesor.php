<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Profesor extends Model
{

    use HasFactory;
    protected $table = 'profesores';


    protected $fillable=[
        'nombre',
        'status',
        'apellidos',
        'email',
    ];


    
    public function academiasRelation(){                
        return $this->belongsToMany(Academia::class, 'academias_profesores', 'profesorid', 'academiaid');
    }
    



    //Para eliminar un profesor, eliminamos la relación con las academias
    protected static function boot(){
        parent::boot();
        static::deleting(function ($profesor) {
            $profesor->academiasRelation()->detach();
        });
    }
}
