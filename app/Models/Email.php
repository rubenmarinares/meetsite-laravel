<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{

    protected $table = 'emails';


    protected $fillable=[
        'academiaid',
        'plantilla',
        'nombre',
        'properties',
        'userid'
    ];

    public function academiaRelation()
    {
        return $this->belongsTo(Academia::class, 'academiaid', 'id');
    }

    public function usersRelation()
    {
        return $this->belongsTo(User::class, 'userid', 'id');
    }

    public function sections(){
        return $this->belongsToMany(Section::class,'email_sections')
            ->withPivot('order')
            ->withTimestamps();
    }
}
