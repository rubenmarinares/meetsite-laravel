<?php

namespace App\Http\Controllers;

use App\Http\Requests\AlumnoRequest;
use App\Models\Alumno;
use Illuminate\Http\Request;

use Illuminate\Http\RedirectResponse;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;


use App\Traits\TraitFormAlumno;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

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

        /*if($user->hasRole('super-admin')){
            $alumnos=Alumno::query()->orderByRaw('nombre')->get();
        }else{            
                
            $alumnos = Alumno::whereHas('academiasRelation', function ($query) use ($user) {
                            $query->whereIn('academiaid', $user->academias()->pluck('id'));
                        })->get();
        } 
        */       

        $alumnos = Alumno::whereHas('academiasRelation', function ($query)  {
                            $query->where('academiaid', session('academia_set')->id);
                        })->get();

        return view('alumnos.index',[
            'alumnos'=>$alumnos,
            'emptyMessage'=>'No hay Alumnos registrados',
            'sidepanel'=>false,
        ]);
    }


    public function edit(Alumno $alumno) : View{        
        $var['sidepanel']=request('sidepanel', false);
        $var['alumno']=$alumno;
        $var['academiasSeleccionadas']=$alumno->academiasRelation->pluck('id')->toArray();

        $vars = TraitFormAlumno::formularioAlumno($var);

        return view('alumnos.edit', $vars);        
    }
    
    

    //ACTUALIZAR RECURSO
    public function update(AlumnoRequest $request,Alumno $alumno){
        try {
            DB::beginTransaction();

            //$redirectUrl = $request->input('redirect_to', route('profesores.index'));
            $validated=($request->validated());
            $alumno->update($validated);
            $alumno->academiasRelation()->sync($request['academias'] ?? []);
    
            //throw new \Exception("Error forzado para probar el catch");
            DB::commit();            
            $successMessages = ['Alumno actualizado con éxito.'];
            session()->flash('success_messages', $successMessages);            

        } catch (\Exception $e) {
            DB::rollBack(); // Revierte todo
            session()->flash('error_messages', [
                "Error al actualizar el recurso.",
                $e->getMessage()
            ]);
        }        
    }


    use TraitFormAlumno;    
    public function create():View{
        $vars = TraitFormAlumno::formularioAlumno();
        //$var['sidepanel']=request('sidepanel', false);
        return view('alumnos.create', $vars);        
    }
    
    
    public function store(AlumnoRequest $request){

        try {
            DB::beginTransaction();
            $validated=($request->validated());
                
            $alumno=Alumno::create($validated);
            $alumno->academiasRelation()->sync($request['academias'] ?? []); // si no vienen, se limpia la relación  

            
            $successMessages = [            
                'Alumno creado con éxito.'
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

        //return redirect()->route('alumnos.index');
    }

    
    public function destroy(Request $request, Alumno $alumno):RedirectResponse{
        try {

            DB::beginTransaction();

            $alumno->delete();

            $redirectUrl = $request->input('redirect_to', route('alumnos.index'));
            $redirectUrl = URL::to($redirectUrl) . (Str::contains($redirectUrl, '?') ? '&' : '?') . 'tab=2';
            
            //throw new \Exception("Forzando error para probar el catch");
            DB::commit();
            $successMessages = [            
                'Alumno eliminado con éxito.'
            ];
            session()->flash('success_messages', $successMessages);
            return redirect()->to($redirectUrl);

        } catch (\Exception $e) {
            DB::rollBack(); // Revierte todo
            session()->flash('error_messages', [
                "Error al crear el recurso.",
                $e->getMessage()
            ]);
            $redirectUrl = $request->input('redirect_to', route('alumnos.index'));
            $redirectUrl = URL::to($redirectUrl) . (Str::contains($redirectUrl, '?') ? '&' : '?') . 'tab=2';

            return redirect()->to($redirectUrl);
        }

        /*
        $alumno->delete();
        $successMessages = ['Alumno eliminado con éxito.'];
        session()->flash('success_messages', $successMessages);   

        $redirectUrl = $request->input('redirect_to', route('alumnos.index'));
        $redirectUrl = URL::to($redirectUrl) . (Str::contains($redirectUrl, '?') ? '&' : '?') . 'tab=2';

        return redirect()->to($redirectUrl);
        */
    }
   

/*public function edit(Alumno $alumno) : View{        
        
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
        
        return view('alumnos.edit',[
                        'alumno'=>$alumno,
                        'submitButtonText'=>'Actualizar Usuario',
                        'actionUrl'=>route('alumnos.update',$alumno),  
                        'method'=>'PUT',
                        'h2Label'=>'Editar Alumno',                        
                        'academiasSeleccionadas'=>$alumno->academiasRelation->pluck('id')->toArray(),
                        'academias'=>$academias,                        
        ]);
    }*/

   /*
   public function destroy(Alumno $alumno):RedirectResponse{        

        $alumno->delete();
        $successMessages = ['Alumno eliminado con éxito.'];
        session()->flash('success_messages', $successMessages);   
        return redirect()->route('alumnos.index');
    }
        */


     /*
     public function update(AlumnoRequest $request,Alumno $alumno):RedirectResponse{
            
        $validated=($request->validated());
         
        $alumno->update($validated);

        $successMessages = ['Alumno actualizado con éxito.'];
        session()->flash('success_messages', $successMessages);        
        
        $alumno->academiasRelation()->sync($request['academias'] ?? []); // si no vienen, se limpia la relación  
   


        return redirect()->route('alumnos.index');
    }
*/
 
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
        */
    //CREACIÓN RECURSO
    
    

}
