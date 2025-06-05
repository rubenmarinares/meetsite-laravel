<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfesorRequest;
use App\Models\Profesor;
use Illuminate\Http\Request;

use Illuminate\Http\RedirectResponse;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Academia;

class ProfesorController extends Controller
{


    public function __construct()
    {
        $this->authorizeResource(Profesor::class,'profesor');       
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        
        $user = Auth::user();

        if($user->hasRole('super-admin')){
            $profesores=Profesor::query()->orderByRaw('nombre')->get();
        }else{            
                
            $profesores = Profesor::whereHas('academiasRelation', function ($query) use ($user) {
                            $query->whereIn('academiaid', $user->academias()->pluck('id'));
                        })->get();
        }

        //$profesores=Profesor::query()->orderByRaw('nombre')->get();

        //var_export($profesores->toArray());
        //dd();

        
        return view('profesores.index',[
            'profesores'=>$profesores,
            'emptyMessage'=>'No hay profesores registrados',
        ]);
    }

    public function create():View{

        $user = Auth::user();
        if($user->hasRole('super-admin')){
            $academias=Academia::query()->orderByRaw('academia')->get();
        
        }else{
            $academias = Academia::query()
                ->whereHas('users', function ($query) use ($user) {
                    $query->where('users.id', $user->id);
                })
                ->orderByRaw('academia')->get();
        }        

        
        // $academias=Academia::query()->orderByRaw('academia')->get();
        // Creamos un nuevo usuario para el formulario

        return view('profesores.create',[
            'profesor'=>new Profesor(),
            'submitButtonText'=>'Crear Profesor',
            'actionUrl'=>route('profesores.store'),
            'method'=>'POST',
            'h2Label'=>'Crear Profesor',            
            'academiasSeleccionadas'=>array(),
            'academias'=>$academias,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProfesorRequest $request): RedirectResponse{
        $validated=($request->validated());
                
        $profesor=Profesor::create($validated);

        
        $successMessages = [            
            'Profesor creado con éxito.'
        ];    
        session()->flash('success_messages', $successMessages);

        //$profesor->academias()->sync($request->input('academias', [])); // si no vienen, se limpia la relación      
        //$profesor->academiasRelation()->sync($request->input('academias', [])); // si no vienen, se limpia la relación  
        $profesor->academiasRelation()->sync($request['academias'] ?? []); // si no vienen, se limpia la relación  

        return redirect()->route('profesores.index');
    }

    public function edit(Profesor $profesor) : View{        
        
        $user = Auth::user();
        if($user->hasRole('super-admin')){
            $academias=Academia::query()->orderByRaw('academia')->get();
        }else{
            $academias = Academia::query()
                ->whereHas('users', function ($query) use ($user) {
                    $query->where('users.id', $user->id);
                })
                ->orderByRaw('academia')->get();
        }

        //$academias=Academia::query()->orderByRaw('academia')->get();

        return view('profesores.edit',[
                        'profesor'=>$profesor,
                        'submitButtonText'=>'Actualizar Usuario',
                        'actionUrl'=>route('profesores.update',$profesor),  
                        'method'=>'PUT',
                        'h2Label'=>'Editar Profesor',                        
                        'academiasSeleccionadas'=>$profesor->academiasRelation->where('status',1)->pluck('id')->toArray(),
                        'academias'=>$academias,                        
        ]);
    }
    
    public function update(ProfesorRequest $request,Profesor $profesor):RedirectResponse{
            
        $validated=($request->validated());
         
        $profesor->update($validated);

        $successMessages = ['Profesor actualizado con éxito.'];
        session()->flash('success_messages', $successMessages);        

        //Sincronizamos los usuarios con las academias
        //$profesor->academiasRelation()->sync($request->input('academias', [])); // si no vienen, se limpia la relación
        $profesor->academiasRelation()->sync($request['academias'] ?? []); // si no vienen, se limpia la relación  
        //Sincronizamos lo usuarios con los roles        


        return redirect()->route('profesores.index');
    }

    /**
     * Remove the specified resource from storage.
     */
   public function destroy(Profesor $profesor):RedirectResponse{        

        $profesor->delete();
        $successMessages = ['Profesor eliminado con éxito.'];
        session()->flash('success_messages', $successMessages);   
        return redirect()->route('profesores.index');
    }

}
