<?php

namespace App\Http\Controllers;

use App\Http\Requests\AsignaturaRequest;
use App\Models\Asignatura;

use Illuminate\Http\Request;

use Illuminate\Http\RedirectResponse;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

use App\Traits\TraitFormAsignatura;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;


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
            'sidepanel'=>false,
        ]);
    }


    public function edit(Asignatura $asignatura) : View{        
        $var['sidepanel']=request('sidepanel', false);
        $var['asignatura']=$asignatura;
        $var['academiasSeleccionadas']=$asignatura->academiasRelation->pluck('id')->toArray();

        $vars = TraitFormAsignatura::formularioAsignatura($var);

        return view('asignaturas.edit', $vars);        
    }
    
    //ACTUALIZAR RECURSO
    public function update(AsignaturaRequest $request,Asignatura $asignatura){
        try {
            DB::beginTransaction();

            //$redirectUrl = $request->input('redirect_to', route('profesores.index'));
            $validated=($request->validated());
            $asignatura->update($validated);
            $asignatura->academiasRelation()->sync($request['academias'] ?? []);
    
            //throw new \Exception("Error forzado para probar el catch");
            DB::commit();            
            $successMessages = ['Asignatura actualizado con éxito.'];
            session()->flash('success_messages', $successMessages);            

        } catch (\Exception $e) {
            DB::rollBack(); // Revierte todo
            session()->flash('error_messages', [
                "Error al actualizar el recurso.",
                $e->getMessage()
            ]);
        }        
    }
   

    //use TraitFormAsignatura;    
    public function create():View{
        $vars = TraitFormAsignatura::formularioAsignatura();
        //$var['sidepanel']=request('sidepanel', false);
        return view('asignaturas.create', $vars);        
    }

public function store(AsignaturaRequest $request){

    try {
        DB::beginTransaction();
        $validated=($request->validated());
                        
        $asignatura=Asignatura::create($validated);
        $asignatura->academiasRelation()->sync($request['academias'] ?? []); // si no vienen, se limpia la relación              
        DB::commit();
        $successMessages = [            
            'Asignatura creada con éxito.'
        ];    
        session()->flash('success_messages', $successMessages);
    } catch (\Exception $e) {
        DB::rollBack(); // Revierte todo
        session()->flash('error_messages', [
            "Error al crear el recurso.",
            $e->getMessage()
        ]);
    }        
}
    
    
    
    public function destroy(Request $request, Asignatura $asignatura):RedirectResponse{   
    
     try {
            DB::beginTransaction();

            $asignatura->delete();

            
            
            //throw new \Exception("Forzando error para probar el catch");
            DB::commit();
            $successMessages = [            
                'Asignatura eliminada con éxito.'
            ];
            session()->flash('success_messages', $successMessages);            

        } catch (\Exception $e) {
            DB::rollBack(); // Revierte todo
            session()->flash('error_messages', [
                "Error al eliminar el recurso.",
                $e->getMessage()
            ]);
            
            
        }   

        $redirectUrl = $request->input('redirect_to', route('asignaturas.index'));
        $redirectUrl = URL::to($redirectUrl) . (Str::contains($redirectUrl, '?') ? '&' : '?') . 'tab=3';
        return redirect()->to($redirectUrl);
    }



     /*
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
    */

    /*
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
    */

    /*public function update(AsignaturaRequest $request,Asignatura $asignatura):RedirectResponse{
            
        $validated=($request->validated());
         
        $asignatura->update($validated);

        $successMessages = ['Asignatura actualizado con éxito.'];
        session()->flash('success_messages', $successMessages);        
    
        $asignatura->academiasRelation()->sync($request['academias'] ?? []); // si no vienen, se limpia la relación  
        //Sincronizamos lo usuarios con los roles        


        return redirect()->route('asignaturas.index');
    }
    */

}
