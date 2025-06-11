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

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;


class UserController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(User::class,'user');
    }
    
    public function index(){       
        
        $user = Auth::user();
        if($user->hasRole('super-admin')){
            
            $usuarios=User::query()->orderByRaw('name')->get();

        }else{                            
            $usuarios = User::whereHas('academiasRelation', function ($query) use ($user) {
                            $query->whereIn('academiaid', $user->academias()->pluck('id'));
                        })->get();                                        
        }        
        
        return view('users.index',[
            'users'=>$usuarios,
            'h2Label'=>'Usuarios',
            'createUrl'=>route('users.create'),
            'createLabel'=>'Nuevo Usuario',
            'emptyMessage'=>'No hay usuarios registrados',
            'totalRegistros'=>$usuarios->count(),
        ]); 

    }

    public function edit(User $user) : View{        
        

        

        $userAuth = Auth::user();
        if($userAuth->hasRole('super-admin')){
            $academias=Academia::query()->orderByRaw('academia')->get();
            $roles=Role::query()->orderByRaw('name')->get();
        }else{
            $academias = Academia::query()
                ->whereHas('users', function ($query) use ($userAuth) {
                    $query->where('users.id', $userAuth->id);
                })
                ->orderByRaw('academia')->get();
            $roles = Role::query()->where('id', '!=', 1) // Exclude 'super-admin' role
                ->orderByRaw('name')->get();
        }



        return view('users.edit',[
                        'usuario'=>$user,
                        'submitButtonText'=>'Actualizar Usuario',
                        'actionUrl'=>route('users.update',$user),  
                        'method'=>'PUT',
                        'h2Label'=>'Editar Usuario',
                        'labelPassword'=>'Nueva contraseña (opcional)',
                        'labelPasswordConfirm'=>'Confirmar contraseña',
                        'academiasSeleccionadas'=>$user->academiasRelation->pluck('id')->toArray(),
                        'academias'=>$academias,
                        'rolesSeleccionados'=>$user->roles->pluck('id')->toArray(),
                        'roles'=>$roles
        ]);


    }


    public function update(UserRequest $request,User $user):RedirectResponse{
       
         try {
            DB::beginTransaction();

            $validated=($request->validated());
            //Modificamos el password solo si se ha modificado
            if($validated['password']!=null){
                $user->password =Hash::make($validated['password']);
            }else{
                unset($validated['password']);            
            }            
            $user->update($validated);

            //Sincronizamos los usuarios con las academias
            $user->academiasRelation()->sync($request['academias'] ?? []); // si no vienen, se limpia la relación
            $user->syncRoles($request['roles'] ?? []);       
            DB::commit(); // Confirma los cambios

            $successMessages = ['Usuario actualizado con éxito.'];
            session()->flash('success_messages', $successMessages);        
        } catch (\Exception $e) {
            DB::rollBack(); // Revierte todo
            session()->flash('error_messages', [
                "Error al actualizar el usuario.",
                $e->getMessage()
            ]);
        }    

        return redirect()->route('users.index');
    }


    public function create():View{

        $user = Auth::user();
        if($user->hasRole('super-admin')){
            $academias=Academia::query()->orderByRaw('academia')->get();
            $roles=Role::query()->orderByRaw('name')->get();
        }else{
            $academias = Academia::query()
                ->whereHas('users', function ($query) use ($user) {
                    $query->where('users.id', $user->id);
                })
                ->orderByRaw('academia')->get();
            $roles = Role::query()->where('id', '!=', 1) // Exclude 'super-admin' role
                ->orderByRaw('name')->get();
        }
        
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
            'academias'=>$academias,
            'rolesSeleccionados'=>array(),
            'roles'=>$roles

        ]);
    }
          
    public function store(UserRequest $request): RedirectResponse{

        try {
            DB::beginTransaction();

            $validated=($request->validated());
            
            $validated['password'] = Hash::make($validated['password']);
            $user=User::create($validated);
            

            //$user->academias()->sync($request['academias'] ?? []); // si no vienen, se limpia la relación
            
            $user->academiasRelation()->sync($request['academias'] ?? []); // si no vienen, se limpia la relación
            $user->syncRoles($request['roles'] ?? []);

            DB::commit(); // Confirma los cambios
            $successMessages = [            
                'Usuario creado con éxito.'
            ];    
            session()->flash('success_messages', $successMessages);

        } catch (\Exception $e) {
            DB::rollBack(); // Revierte todo
            session()->flash('error_messages', [
                "Error al actualizar el aula.",
                $e->getMessage()
            ]);
        }

        return redirect()->route('users.index');
    }

    public function destroy(User $user):RedirectResponse{
        $user->delete();
        return redirect()->route('users.index');
    }

}
