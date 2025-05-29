<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{        

    protected $fillable=[
        'name',
        'guard_name',        
    ];

    protected $table = 'permissions';

   
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_has_permissions', 'permission_id', 'role_id');
    }
   

    public static function guardName()
    {
        return array('web','api','admin','custom_guard');
    }



    

}
