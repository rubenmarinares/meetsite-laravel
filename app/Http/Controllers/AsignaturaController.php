<?php

namespace App\Http\Controllers;

use App\Http\Requests\AsignaturaRequest;
use App\Models\Asignatura;

use App\Models\Academia;
use Illuminate\Http\Request;

use Illuminate\Http\RedirectResponse;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class AsignaturaController extends Controller
{


    
    public function __construct()
    {
        $this->authorizeResource(Asignatura::class,'asignatura');       
    }
    

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        
        $user = Auth::user();

        if($user->hasRole('super-admin')){
            $asignaturas=Asignatura::query()->orderByRaw('asignatura')->get();
        }else{            
                
            $asignaturas = Asignatura::whereHas('academiasRelation', function ($query) use ($user) {
                            $query->whereIn('academiaid', $user->academias()->pluck('id'));
                        })->get();
        }

        
        return view('asignaturas.index',[
            'asignaturas'=>$asignaturas,
            'emptyMessage'=>'No hay asignaturas registrados',
        ]);
    }

    public function edit(Asignatura $asignatura) : View{        
        
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

        return view('asignaturas.edit',[
                        'asignatura'=>$asignatura,
                        'submitButtonText'=>'Actualizar Asignatura',
                        'actionUrl'=>route('asignaturas.update',$asignatura),  
                        'method'=>'PUT',
                        'h2Label'=>'Editar Asignatura',                        
                        'academiasSeleccionadas'=>$asignatura->academiasRelation->pluck('id')->toArray(),
                        'academias'=>$academias,                        
        ]);
    }

    public function update(AsignaturaRequest $request,Asignatura $asignatura):RedirectResponse{
            
        $validated=($request->validated());
         
        $asignatura->update($validated);

        $successMessages = ['Asignatura actualizado con éxito.'];
        session()->flash('success_messages', $successMessages);        

        //Sincronizamos los usuarios con las academias
        //$asignatura->academiasRelation()->sync($request->input('academias', [])); // si no vienen, se limpia la relación
        $asignatura->academiasRelation()->sync($request['academias'] ?? []); // si no vienen, se limpia la relación  
        //Sincronizamos lo usuarios con los roles        


        return redirect()->route('asignaturas.index');
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
                

        return view('asignaturas.create',[
            'asignatura'=>new Asignatura(),
            'submitButtonText'=>'Crear Asignatura',
            'actionUrl'=>route('asignaturas.store'),
            'method'=>'POST',
            'h2Label'=>'Crear Asignatura',            
            'academiasSeleccionadas'=>array(),
            'academias'=>$academias,
        ]);
    
    }

    public function store(AsignaturaRequest $request): RedirectResponse{
        $validated=($request->validated());
                
        $asignatura=Asignatura::create($validated);

        
        $successMessages = [            
            'Asignatura creado con éxito.'
        ];    
        session()->flash('success_messages', $successMessages);
          
        $asignatura->academiasRelation()->sync($request['academias'] ?? []); // si no vienen, se limpia la relación  

        return redirect()->route('asignaturas.index');
    }
    
    
    
    
   public function destroy(Asignatura $asignatura):RedirectResponse{        

        $asignatura->delete();
        $successMessages = ['Asignatura eliminado con éxito.'];
        session()->flash('success_messages', $successMessages);   
        return redirect()->route('asignaturas.index');
    }

}
