<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Requests\PermissionRequest;

use Illuminate\Http\RedirectResponse;


class PermissionController extends Controller
{


    public function __construct()
    {
        $this->authorizeResource(Permission::class);
    }


    public function index():View{
        
        
        $permissions=Permission::latest('id')->paginate(10);

        $permissions->each(function($permission){
            $permission->roles_count=$permission->roles()->count();
        });
        
                        
        return view('permissions.index',[
            'permissions'=>$permissions,
            'h2Label'=>'Permisos',
            'createUrl'=>route('permissions.create'),
            'createLabel'=>'Nuevo Permiso',
            'emptyMessage'=>'No hay permisos registrados',
            'totalRegistros'=>$permissions->total(),      
        ]);        
        //return view('permissions.index',compact('permissions'));

    }


    public function edit(Permission $permission) : View{
        return view('permissions.edit',[
                        'permission'=>$permission,
                        'submitButtonText'=>'Actualizar Permiso',
                        'actionUrl'=>route('permissions.update',$permission),  
                        'method'=>'PUT',
                        'rolesSeleccionados'=>$permission->roles->pluck('id')->toArray(),
                        'roles'=>Role::query()->orderByRaw('name')->get(),
                        'h2Label'=>'Editar Permiso',
                        'guardNames'=>Permission::guardName(),
        ]);
    }

    public function update(PermissionRequest $request,Permission $permission):RedirectResponse{
            
        $validated=($request->validated());
        $permission->update($validated);

        $successMessages = [            
            'Permiso actualizado con éxito.'
        ];        
        session()->flash('success_messages', $successMessages);

        return redirect()->route('permissions.index');
    }

    public function create():View{
     
        return view('permissions.create',[
            'permission'=>new Permission,
            'submitButtonText'=>'Crear Permiso',
            'actionUrl'=>route('permissions.store'),
            'method'=>'POST',            
            'rolesSeleccionados'=>array(),
            'roles'=>Role::query()->orderByRaw('name')->get(),
            'h2Label'=>'Editar Permiso',
            'guardNames'=>Permission::guardName(),        

        ]);
    }
          
    public function store(PermissionRequest $request): RedirectResponse{
        $validated=($request->validated());
        Permission::create($validated);
        $successMessages = [            
            'Permiso creado con éxito.'
        ];        
        session()->flash('success_messages', $successMessages);
        return redirect()->route('permissions.index');
    }

    public function destroy(Permission $permission):RedirectResponse{
        $permission->delete();
        return redirect()->route('permissions.index');
    }







}
