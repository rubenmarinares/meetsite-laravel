<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    //

    protected $table = 'clientes';


    protected $fillable=[
        'nombre',
        'apellidos',
        'email',
        'properties',
    ];



     public function academiasRelation(){                
        return $this->belongsToMany(Academia::class, 'academias_clientes', 'clienteid', 'academiaid');
    }

    public function alumnosRelation(){                
        return $this->belongsToMany(Academia::class, 'academias_clientes', 'alumnoid', 'academiaid');
    }
}
