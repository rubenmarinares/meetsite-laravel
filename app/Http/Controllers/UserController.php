<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Academia;
use App\Models\Role;
use Illuminate\Http\Request;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;




class UserController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(User::class,'user');
    }
    
    public function index(){       

        $users=User::latest('id')->paginate(10);
        
        return view('users.index',[
            'users'=>$users,
            'h2Label'=>'Usuarios',
            'createUrl'=>route('users.create'),
            'createLabel'=>'Nuevo Usuario',
            'emptyMessage'=>'No hay usuarios registrados',
            'totalRegistros'=>$users->total(),
        ]); 

    }

    public function edit(User $user) : View{

        return view('users.edit',[
                        'usuario'=>$user,
                        'submitButtonText'=>'Actualizar Usuario',
                        'actionUrl'=>route('users.update',$user),  
                        'method'=>'PUT',
                        'h2Label'=>'Editar Usuario',
                        'labelPassword'=>'Nueva contraseña (opcional)',
                        'labelPasswordConfirm'=>'Confirmar contraseña',
                        'academiasSeleccionadas'=>$user->academiasRelation->where('status',1)->pluck('id')->toArray(),
                        'academias'=>Academia::query()->where('status',1)->orderByRaw('academia')->get(),
                        'rolesSeleccionados'=>$user->roles->pluck('id')->toArray(),
                        'roles'=>Role::query()->orderByRaw('name')->get()
        ]);
    }


    public function update(UserRequest $request,User $user):RedirectResponse{
            
        $validated=($request->validated());

        //Modificamos el password solo si se ha modificado
        if($validated['password']!=null){
            $user->password =Hash::make($validated['password']);
        }else{
            unset($validated['password']);            
        }

       // $user->password =Hash::make($validated['password']);        
        $user->update($validated);

        $successMessages = ['Usuario actualizado con éxito.'];
        session()->flash('success_messages', $successMessages);
        //session()->flash('error_messages', ['Error.']);

        //Sincronizamos los usuarios con las academias
        $user->academias()->sync($request->input('academias', [])); // si no vienen, se limpia la relación
        //Sincronizamos lo usuarios con los roles        
        $user->syncRoles($request->input('roles', []));        
        

        return redirect()->route('users.index');
    }


    public function create():View{
        // Creamos un nuevo usuario para el formulario     
        return view('users.create',[
            'usuario'=>new User,
            'submitButtonText'=>'Crear Usuario',
            'actionUrl'=>route('users.store'),
            'method'=>'POST',
            'h2Label'=>'Crear Usuario',
            'labelPassword'=>'Introduce contraseña *',
            'labelPasswordConfirm'=>'Confirmar Contraseña *',
            'academiasSeleccionadas'=>array(),
            'academias'=>Academia::query()->where('status',1)->orderByRaw('academia')->get(),
            'rolesSeleccionados'=>array(),
            'roles'=>Role::query()->orderByRaw('name')->get()

        ]);
    }
          
    public function store(UserRequest $request): RedirectResponse{
        $validated=($request->validated());
        
        $validated['password'] = Hash::make($validated['password']);
        $user=User::create($validated);
        $successMessages = [            
            'Usuario creado con éxito.'
        ];    
        session()->flash('success_messages', $successMessages);

        $user->academias()->sync($request->input('academias', [])); // si no vienen, se limpia la relación
        $user->syncRoles($request->input('roles', []));

        return redirect()->route('users.index');
    }

    public function destroy(User $user):RedirectResponse{
        $user->delete();
        return redirect()->route('users.index');
    }

}
