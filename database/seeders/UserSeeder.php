<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Role as ModelsRole;

use App\Models\User;
use Illuminate\Queue\Jobs\SyncJob;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Permission::create(['name' => 'ver usuarios']);
        Permission::create(['name' => 'editar usuarios']);
        Permission::create(['name' => 'crear usuarios']);
        Permission::create(['name' => 'eliminar usuarios']);


        
        $adminUser=User::query()->create([
            'name'=>'super admin',
            'email'=>'superadmin@admin.com',
            'password'=>12345,
            'email_verified_at'=>now()]);

            
        $roleAdmin = Role::create(['name' => 'super-admin']);

        $adminUser->assignRole('super-admin');

        $permissionAdmin=Permission::query()->pluck('name');
        $roleAdmin->syncPermissions($permissionAdmin);



        $gerenteUser=User::query()->create([
            'name'=>'admin',
            'email'=>'admin@admin.com',
            'password'=>12345,
            'email_verified_at'=>now()]);
        $roleGerente = Role::create(['name' => 'admin']);
        $gerenteUser->assignRole('admin');

        $roleGerente->syncPermissions(['ver usuarios','editar usuarios']);





    }




}
