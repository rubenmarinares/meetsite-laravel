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

}