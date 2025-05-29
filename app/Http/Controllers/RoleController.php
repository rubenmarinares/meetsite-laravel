<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use App\Http\Requests\RoleRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        $this->authorizeResource(Role::class,'role');       
    }
        
    public function index():View{
                
        $roles=Role::latest('id')->paginate(10);

        $roles->each(function($role){
            $role->permission_count=$role->permissions()->count();
        });
        
        return view('roles.index',[
            'roles'=>$roles,
            'h2Label'=>'Roles',
            'createUrl'=>route('roles.create'),
            'createLabel'=>'Nuevo Role',
            'emptyMessage'=>'No hay roles registrados',
            'totalRegistros'=>$roles->total(),      
        ]);    
    }

    public function edit(Role $role) : View{        
        return view('roles.edit',[
                        'role'=>$role,
                        'submitButtonText'=>'Actualizar Rol',
                        'actionUrl'=>route('roles.update',$role),  
                        'method'=>'PUT',
                        'permisosSeleccionados'=>$role->permissions->pluck('id')->toArray(),
                        'permisos'=>Permission::query()->orderByRaw('name')->get(),
                        'h2Label'=>'Editar Role',
                        'guardNames'=>Role::guardName(),
        ]);
    }


    public function update(RoleRequest $request,Role $role):RedirectResponse{            
        $validated=($request->validated());
        $role->update($validated);
        $successMessages = [            
            'Role actualizado con éxito.'
        ];        
        session()->flash('success_messages', $successMessages);
        $role->permissions()->sync($request->input('permissions', [])); // si no vienen, se limpia la relación

        return redirect()->route('roles.index');
    }



    public function create():View{
     
        return view('roles.create',[
            'role'=>new Role,
            'submitButtonText'=>'Crear Role',
            'actionUrl'=>route('roles.store'),
            'method'=>'POST',            
            'permisosSeleccionados'=>array(),
            'permisos'=>Permission::query()->orderByRaw('name')->get(),
            'h2Label'=>'Editar Role',
            'guardNames'=>Role::guardName(),        

        ]);
    }
          
    public function store(RoleRequest $request): RedirectResponse{
        $validated=($request->validated());
        $role=Role::create($validated);

        

        $successMessages = [            
            'Role creado con éxito.'
        ];        
        session()->flash('success_messages', $successMessages);
        $role->permissions()->sync($request->input('permissions', [])); // si no vienen, se limpia la relación


        //return redirect()->route('roles.index');
        return redirect()->route('roles.edit', $role);




    }

    public function destroy(Role $role):RedirectResponse{
        $role->delete();
        return redirect()->route('roles.index');
    }
}
