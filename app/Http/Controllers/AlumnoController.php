<?php

namespace App\Http\Controllers;

use App\Http\Requests\AlumnoRequest;
use App\Models\Alumno;
use Illuminate\Http\Request;

use Illuminate\Http\RedirectResponse;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Academia;

class AlumnoController extends Controller
{


    public function __construct()
    {
        $this->authorizeResource(Alumno::class,'alumno');       
    }
    

    /**
     * Display a listing of the resource.
     */
    public function index()
    {        
        $user = Auth::user();

        if($user->hasRole('super-admin')){
            $alumnos=Alumno::query()->orderByRaw('nombre')->get();
        }else{            
                
            $alumnos = Alumno::whereHas('academiasRelation', function ($query) use ($user) {
                            $query->whereIn('academiaid', $user->academias()->pluck('id'));
                        })->get();
        }
    
        
        return view('alumnos.index',[
            'alumnos'=>$alumnos,
            'emptyMessage'=>'No hay Alumnos registrados',
        ]);
    }

    public function edit(Alumno $alumno) : View{        
        
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

        return view('alumnos.edit',[
                        'alumno'=>$alumno,
                        'submitButtonText'=>'Actualizar Usuario',
                        'actionUrl'=>route('alumnos.update',$alumno),  
                        'method'=>'PUT',
                        'h2Label'=>'Editar Alumno',                        
                        'academiasSeleccionadas'=>$alumno->academiasRelation->pluck('id')->toArray(),
                        'academias'=>$academias,                        
        ]);
    }


     public function update(AlumnoRequest $request,Alumno $alumno):RedirectResponse{
            
        $validated=($request->validated());
         
        $alumno->update($validated);

        $successMessages = ['Alumno actualizado con éxito.'];
        session()->flash('success_messages', $successMessages);        

        //Sincronizamos los usuarios con las academias
        //$alumno->academiasRelation()->sync($request->input('academias', []));      
        $alumno->academiasRelation()->sync($request['academias'] ?? []); // si no vienen, se limpia la relación  
   


        return redirect()->route('alumnos.index');
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
                

        return view('alumnos.create',[
            'alumno'=>new Alumno(),
            'submitButtonText'=>'Crear Alumno',
            'actionUrl'=>route('alumnos.store'),
            'method'=>'POST',
            'h2Label'=>'Crear Alumno',            
            'academiasSeleccionadas'=>array(),
            'academias'=>$academias,
        ]);
    
    }
    
    
    public function store(AlumnoRequest $request): RedirectResponse{
        $validated=($request->validated());
                
        $alumno=Alumno::create($validated);

        
        $successMessages = [            
            'Alumno creado con éxito.'
        ];    
        session()->flash('success_messages', $successMessages);
          
        $alumno->academiasRelation()->sync($request['academias'] ?? []); // si no vienen, se limpia la relación  

        return redirect()->route('alumnos.index');
    }

    
    
   


   public function destroy(Alumno $alumno):RedirectResponse{        

        $alumno->delete();
        $successMessages = ['Alumno eliminado con éxito.'];
        session()->flash('success_messages', $successMessages);   
        return redirect()->route('alumnos.index');
    }
    

}
