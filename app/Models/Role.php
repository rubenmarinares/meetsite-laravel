<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{    

   
    protected $fillable=[
        'name',
        'guard_name',        
    ];

    protected $table = 'roles';

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_has_permissions', 'role_id', 'permission_id');
    }


    public static function guardName()
    {
        return array('web','api','admin','custom_guard');
    }



}
