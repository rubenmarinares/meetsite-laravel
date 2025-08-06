<?php

namespace App\Http\Controllers;

use App\Http\Requests\AcademiaRequest;
use App\Models\Academia;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;



class AcademiaController extends Controller
{    
    public function __construct()
    {
        $this->authorizeResource(Academia::class);
    }
    
    

    public function index():View{

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
        //MOSTRAR EL NÚMERO DE ALUMNOS QUE  TIENE CADA ACADEMIA
        /*$academias->each(function($academia){
            $academia->alumnos_count=$academia->alumnos()->count();
        });
        */
        
        foreach($academias as $academia){            
            $academia->properties=json_decode($academia->properties,true);
        }
        
        //return view('academias.index',compact('academias'));
        return view('academias.index',[
            'academias'=>$academias,
            'emptyMessage'=>'No hay academias registradas',
        ]);

    }

    public function view(Academia $academia):View{


        //$academiaSet = Academia::find($academia->id);


        $academia= Academia::query()
            ->where('id', $academia->id)
            ->with(['users','alumnos'])
            ->firstOrFail();
        


        $profesores = $academia->profesores()->orderByRaw('nombre')->get();
        $alumnos = $academia->alumnos()->orderByRaw('nombre')->get();
        return view('academias.view',[
            'academia'=>$academia,
            'profesores'=>$profesores,
            'alumnos'=>$alumnos,
            'sidepanel'=>true,
            'emptyMessage'=>'No hay academias registradas'            
        ]);


    }




    
    public function setAcademia(Academia $academia): RedirectResponse{


        $this->authorize('setAcademia', $academia); // Esto llama a la policy

        $user = Auth::user();    
        $academiaSet = Academia::find($academia->id);
        if($academiaSet){
            session()->put('academia_set', $academiaSet);
        }        
        //Añadimos academias actuallizadas a la sesión
        $academias = $user->academias();
        session()->put('user_academias', $academias);

        session()->flash('success_messages', ['Academia seleccionada correctamente.']);

        return redirect()->route('academias.view',$academiaSet);
        

    }

    

    public function create():View{

        
        return view('academias.create',[
            'academia'=>new Academia,
            'submitButtonText'=>'crear_academia',
            'actionUrl'=>route('academias.store'),
            'method'=>'POST',
            'properties'=>Academia::propertiesDefault(),
            'tipos' => Academia::tipos(),
            'alumnosSeleccionados'=>array(),
            //'alumnos'=>Alumno::query()->orderByRaw('apellidos')->get(),

        ]);

    }
    
    public function edit(Academia $academia) : View{
        
        return view('academias.edit',[
        //return view('academias.partials.form',[
                        'academia'=>$academia,
                        'submitButtonText'=>'actualizar_academia',
                        'actionUrl'=>route('academias.update',$academia),                        
                        'method'=>'PUT',
                        'properties'=>json_decode($academia["properties"],true),
                        'tipos' => Academia::tipos(),
                        //'alumnosSeleccionados'=>$academia->alumnos->pluck('id')->toArray(),
                        //'alumnos'=>Alumno::query()->orderByRaw('apellidos')->get(),
                        
                    ]);
                }
                
    public function update(AcademiaRequest $request,Academia $academia):RedirectResponse{
                    
        try {

            
            DB::beginTransaction();
            
            $validated = $request->validated();
            if (!isset($validated['completed'])) {
                $validated['completed'] = 0;
            }

            $validated["properties"] = json_encode($validated["properties"]);
            $academia->update($validated);
            
            //Sincronizamos los alumnos de la academia
            //$academia->alumnos()->sync($request->input('alumnos', [])); // si no vienen, se limpia la relación
            //throw new \Exception('Error forzado'); // Esto sí entra al catch

            //Actualizamos desplegable
            $user = Auth::user();
            $academias = $user->academias();
            session()->put('user_academias', $academias);
            if(session('academia_set')->id==$academia->id){
                session()->put('academia_set', $academia);
            }
            
            DB::commit();
            
            session()->flash('success_messages', [__('academia.messages.success')]);
            
        } catch (\Exception $e) {
            DB::rollBack(); // Revierte todo
            
            session()->flash('error_messages', [
                __('academia.messages.error'),
                $e->getMessage()
            ]);
        }

        return redirect()->route('academias.index');
        
        
    }
    
    public function store(AcademiaRequest $request): RedirectResponse{
        
        $validated=($request->validated());
        if (!isset($validated['completed'])) {
            $validated['completed'] = 0;
        }

        $validated["properties"]=json_encode($validated["properties"]);



        $academia=Academia::create($validated);

        //AHORA si el usuario es admin le asignamos la academia
        $userAuth = Auth::user();
        if($userAuth->hasRole('admin')){
            $academia->users()->attach($userAuth->id);  
        }


        //Sincronizamos los alumnos de la academia
        //$academia->alumnos()->sync($request->input('alumnos', [])); // si no vienen, se limpia la relación


        //Actualizamos desplegable academias
        $user = Auth::user();
        $academias = $user->academias();
        session()->put('user_academias', $academias);
        

        return redirect()->route('academias.index');
        }
        
    public function destroy(Academia $academia):RedirectResponse{
        $academia->delete();
        return redirect()->route('academias.index');
    }
    
    
}
