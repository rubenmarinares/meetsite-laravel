<?php

namespace App\Http\Controllers;

use App\Http\Requests\AulaRequest;
use App\Models\Aula;
use App\Models\Academia;
use Illuminate\Http\Request;

use Illuminate\Http\RedirectResponse;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;


use Illuminate\Support\Facades\DB;
class AulaController extends Controller
{


    
    public function __construct()
    {
        $this->authorizeResource(Aula::class,'aula');       
    }
    

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        
        $user = Auth::user();

        if($user->hasRole('super-admin')){
            $aulas=Aula::query()->orderByRaw('aula')->get();
        }else{            
                
            $aulas = Aula::whereHas('academiasRelation', function ($query) use ($user) {
                            $query->whereIn('academiaid', $user->academias()->pluck('id'));
                        })->get();
        }

        foreach($aulas as $aula){            
            $aula->properties=json_decode($aula->properties,true);
        }
                
        return view('aulas.index',[
            'aulas'=>$aulas,
            'emptyMessage'=>'No hay aulas registrados',
        ]);
    }

    public function edit(Aula $aula) : View{        
        
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

        return view('aulas.edit',[
                        'aula'=>$aula,
                        'submitButtonText'=>'Actualizar Aula',
                        'actionUrl'=>route('aulas.update',$aula),  
                        'method'=>'PUT',
                        'properties'=>json_decode($aula["properties"],true),
                        'h2Label'=>'Editar Asignatura',                        
                        'academiasSeleccionadas'=>$aula->academiasRelation->pluck('id')->toArray(),
                        'academias'=>$academias,                        
        ]);
    }


    public function update(AulaRequest $request,Aula $aula):RedirectResponse{
        
        try {
            DB::beginTransaction();        

            $validated=($request->validated());
            $validated["properties"] = json_encode($validated["properties"]);
            $aula->update($validated);
            
            $successMessages = ['Aula actualizado con éxito.'];
            
            //Sincronizamos los usuarios con las academias        
            $aula->academiasRelation()->sync($request['academias'] ?? []); // si no vienen, se limpia la relación          
            
            DB::commit();
            session()->flash('success_messages', $successMessages);        


        } catch (\Exception $e) {
            DB::rollBack(); // Revierte todo
            
            session()->flash('error_messages', [
                "Error al actualizar el aula.",
                $e->getMessage()
            ]);
        }

        return redirect()->route('aulas.index');
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
                

        return view('aulas.create',[
            'aula'=>new Aula(),
            'submitButtonText'=>'Crear Aula',
            'actionUrl'=>route('aulas.store'),
            'properties'=>Aula::propertiesDefault(),
            'method'=>'POST',
            'h2Label'=>'Crear Aula',            
            'academiasSeleccionadas'=>array(),
            'academias'=>$academias,
        ]);
    
    }

    
    public function store(AulaRequest $request): RedirectResponse{


        try {
            DB::beginTransaction();

            $validated=($request->validated());
            $validated["properties"] = json_encode($validated["properties"]);
            $aula=Aula::create($validated);
            
            
            //Sincronizamos los usuarios con las academias        
            $aula->academiasRelation()->sync($request['academias'] ?? []); // si no vienen, se limpia la relación          
            
            DB::commit();            
            $successMessages = ['Aula creado con éxito.'];
            session()->flash('success_messages', $successMessages);        


        } catch (\Exception $e) {
            DB::rollBack(); // Revierte todo
            
            session()->flash('error_messages', [
                "Error al actualizar el aula.",
                $e->getMessage()
            ]);
        }

        return redirect()->route('aulas.index');

    }
    
    
    
    
   public function destroy(Aula $aula):RedirectResponse{        

        $aula->delete();
        $successMessages = ['Aula eliminada con éxito.'];
        session()->flash('success_messages', $successMessages);   
        return redirect()->route('aulas.index');
    }
    

}
