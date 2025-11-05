<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{

    protected $table = 'sections';


    protected $fillable=[
        'section',
        'type',
        'order',
        'status',
        'properties'        
    ];    

    public function emails()
    {
        return $this->belongsToMany(Email::class, 'email_sections')
                    ->withPivot('order')
                    ->withTimestamps();
    }
        
}
