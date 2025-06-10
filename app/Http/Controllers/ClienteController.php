<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClienteRequest;
use App\Models\Cliente;
use App\Models\Academia;
use App\Models\Alumno;
use Illuminate\Http\Request;

use Illuminate\Http\RedirectResponse;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;


use Illuminate\Support\Facades\DB;
class ClienteController extends Controller
{


    
    
    public function __construct()
    {
        $this->authorizeResource(Cliente::class,'cliente');       
    }
    

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        
        $user = Auth::user();

        if($user->hasRole('super-admin')){
            $clientes=Cliente::query()->orderByRaw('nombre')->get();
        }else{            
                
            $clientes = Cliente::whereHas('academiasRelation', function ($query) use ($user) {
                            $query->whereIn('academiaid', $user->academias()->pluck('id'));
                        })->get();
        }

        foreach($clientes as $cliente){            
            $cliente->properties=json_decode($cliente->properties,true);
        }
                
        return view('clientes.index',[
            'clientes'=>$clientes,
            'emptyMessage'=>'No hay cliente registrados',
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
                

        return view('clientes.create',[
            'cliente'=>new Cliente(),
            'submitButtonText'=>'Crear Cliente',
            'actionUrl'=>route('clientes.store'),
            //'properties'=>Cliente::propertiesDefault(),
            'method'=>'POST',
            'h2Label'=>'Crear Cliente',            
            'academiasSeleccionadas'=>array(),
            'academias'=>$academias,
        ]);
    
    }

    
    public function store(ClienteRequest $request): RedirectResponse{


        try {
            DB::beginTransaction();        

            $validated=($request->validated());
            //$validated["properties"] = json_encode($validated["properties"]);
            $cliente=Cliente::create($validated);
            
            
            //Sincronizamos los usuarios con las academias        
            $cliente->academiasRelation()->sync($request['academias'] ?? []); // si no vienen, se limpia la relación          
            
            DB::commit();            
            $successMessages = ['Cliente creado con éxito.'];
            session()->flash('success_messages', $successMessages);        


        } catch (\Exception $e) {
            DB::rollBack(); // Revierte todo
            
            session()->flash('error_messages', [
                "Error al crear el Cliente.",
                $e->getMessage()
            ]);
        }

        return redirect()->route('clientes.index');

    }


    
    public function edit(Cliente $cliente) : View{        
        
        $user = Auth::user();
        if($user->hasRole('super-admin')){
            $academias=Academia::query()->orderByRaw('academia')->get();
            //$alumnos=Alumno::query()->orderByRaw('nombre')->get();
            $alumnosSelected = $cliente->alumnosRelation->pluck('id')->toArray();
        }else{
            $academias = Academia::query()
                ->whereHas('users', function ($query) use ($user) {
                    $query->where('users.id', $user->id);
                })
                ->orderByRaw('academia')->get();            
            
        }
        
        $clienteId = $cliente->id;
        $alumnosSelected = Alumno::whereHas('academiasRelation', function ($query) use ($academias) {
            $query->whereIn('academiaid', $academias->pluck('id'));
            })
            ->select('alumnos.*')
            ->selectSub(function ($query) use ($clienteId) {
                $query->from('academias_clientes')
                    ->select('clienteid')
                    ->whereColumn('alumnoid', 'alumnos.id')
                    ->where('clienteid', $clienteId)
                    ->limit(1);
            }, 'clienteid')
            ->distinct()
            ->get();
        
        return view('clientes.edit',[
                        'cliente'=>$cliente,
                        'submitButtonText'=>'Actualizar Cliente',
                        'actionUrl'=>route('clientes.update',$cliente),  
                        'method'=>'PUT',
                        //'properties'=>json_decode($aula["properties"],true),
                        'h2Label'=>'Editar Cliente',                        
                        'academiasSeleccionadas'=>$cliente->academiasRelation->pluck('id')->toArray(),
                        'alumnosSelected'=>$alumnosSelected ?? [],
                        'academias'=>$academias                        
        ]);
    }


    public function update(ClienteRequest $request,Cliente $cliente):RedirectResponse{

        

        try {
            DB::beginTransaction();        

            $validated=($request->validated());
            //$validated["properties"] = json_encode($validated["properties"]);
            $cliente->update($validated);
            
            $successMessages = ['Cliente actualizado con éxito.'];
            
            //Sincronizamos los usuarios con las academias        
            //$cliente->academiasRelation()->sync($request['academias'] ?? []); // si no vienen, se limpia la relación
            $syncData = [];
            foreach($request['academias'] as $academiaId){
                if($request["alumnos"] ?? false){
                    foreach($request["alumnos"] as $alumnoId){
                        $syncData[] = [
                            'academiaid' => $academiaId,
                            'clienteid' => $cliente->id,
                            'alumnoid' => $alumnoId,
                        ];
                    }
                }else{
                    $syncData[] = [
                            'academiaid' => $academiaId,
                            'clienteid' => $cliente->id,
                            'alumnoid' => null, // Si no hay alumnos, dejamos este campo como null                          
                        ];
                }
            }
            DB::table('academias_clientes')
                ->where('clienteid', $cliente->id)
                ->delete(); // Elimina relaciones anteriores
            DB::table('academias_clientes')->insert($syncData);

            DB::commit();
            session()->flash('success_messages', $successMessages);        


        } catch (\Exception $e) {
            DB::rollBack(); // Revierte todo
            
            session()->flash('error_messages', [
                "Error al actualizar el cliente.",
                $e->getMessage()
            ]);
        }

        return redirect()->route('clientes.index');
    }
        
   
   public function destroy(Cliente $cliente):RedirectResponse{        

        $cliente->delete();
        $successMessages = ['Cliente eliminada con éxito.'];
        session()->flash('success_messages', $successMessages);   
        return redirect()->route('clientes.index');
    }
    
    

}
