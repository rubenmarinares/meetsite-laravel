<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfesorRequest;
use App\Models\Profesor;
use Illuminate\Http\Request;

use Illuminate\Http\RedirectResponse;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Academia;

use App\Traits\TraitFormProfesor;

use Illuminate\Support\Facades\DB;

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
        $user = Auth::user();
        if($user->hasRole('super-admin')){
            $profesores=Profesor::query()->orderByRaw('nombre')->get();
        }else{            
            $profesores = Profesor::whereHas('academiasRelation', function ($query) use ($user) {
                            $query->whereIn('academiaid', $user->academias()->pluck('id'));
                        })->get();
        }
        return view('profesores.index',[
            'profesores'=>$profesores,
            'emptyMessage'=>'No hay profesores registrados',
            'sidepanel'=>false,
        ]);
    }

    //CREACIÓN RECURSO
    use TraitFormProfesor;    
    public function create():View{
        $vars = TraitFormProfesor::formularioProfesor();
        //$var['sidepanel']=request('sidepanel', false);
        return view('profesores.create', $vars);        
    }

    //EDICIÓN RECURSO
     public function edit(Profesor $profesor) : View{        
        $var['sidepanel']=request('sidepanel', false);
        $var['profesor']=$profesor;
        $var['academiasSeleccionadas']=$profesor->academiasRelation->pluck('id')->toArray();        
        $vars = TraitFormProfesor::formularioProfesor($var);

        return view('profesores.edit', $vars);        
    }

    //GUARDAR RECURSO
    public function store(ProfesorRequest $request){

        try {
            DB::beginTransaction();
            $validated=($request->validated());
            
            $profesor=Profesor::create($validated);
            $profesor->academiasRelation()->sync($request['academias'] ?? []); 
            $successMessages = [            
                'Profesor creado con éxito.'
            ];    
            session()->flash('success_messages', $successMessages);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack(); // Revierte todo
            session()->flash('error_messages', [
                "Error al crear el recurso.",
                $e->getMessage()
            ]);
        }
        //return redirect()->route('profesores.index');
    }


    
    //ACTUALIZAR RECURSO
    public function update(ProfesorRequest $request,Profesor $profesor){
        try {
            DB::beginTransaction();

            $redirectUrl = $request->input('redirect_to', route('profesores.index'));
            $validated=($request->validated());
            $profesor->update($validated);
            $profesor->academiasRelation()->sync($request['academias'] ?? []);
    
            //throw new \Exception("Error forzado para probar el catch");
            DB::commit();            
            $successMessages = ['Profesor actualizado con éxito.'];
            session()->flash('success_messages', $successMessages);            

        } catch (\Exception $e) {
            DB::rollBack(); // Revierte todo
            session()->flash('error_messages', [
                "Error al actualizar el recurso.",
                $e->getMessage()
            ]);
        }
        //return redirect()->to($redirectUrl);
    }

   public function destroy(Request $request, Profesor $profesor):RedirectResponse{
        $profesor->delete();
        $successMessages = ['Profesor eliminado con éxito.'];
        session()->flash('success_messages', $successMessages);   

        $redirectUrl = $request->input('redirect_to', route('profesores.index'));
        return redirect()->to($redirectUrl);
    }

}
