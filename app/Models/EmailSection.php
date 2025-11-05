<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailSection extends Model
{

    protected $table = 'email_sections';

    protected $fillable=[
        'emailid',
        'sectionid',
        'order',
        'properties'        
    ];

    public function section(){
        return $this->belongsTo(Section::class, 'sectionid');
    }

    public function blocks(){
        return $this->hasMany(EmailBlock::class, 'sectionid')
                    ->orderBy('col')
                    ->orderBy('order');
    }

}
