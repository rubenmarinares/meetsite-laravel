<?php

namespace App\Traits;

use App\Models\Academia;
use App\Models\Cliente;
use App\Models\Alumno;
use Illuminate\Support\Facades\Auth;

trait TraitFormCliente
{
    static function formularioCliente(array $data = []): array
    {

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
            
        
        
        if(isset($data['cliente']) && $data['cliente'] instanceof Cliente && $data['cliente']->exists){ //EDICIÓN            
            

            
            $cliente = $data['cliente'];
            //$properties=json_decode($cliente["properties"],true);
            $method = 'PUT';
            $actionUrl = route('clientes.update', $cliente->id);
            $submitButtonText = 'Actualizar Cliente';

            $clienteId = $cliente->id;
            $academias = Academia::where('id', session('academia_set')->id)->get();
            
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
            $alumnosPreSelected = $data['alumnosPreSelected'] ?? [];
        }else{ //CREACIÓN
                        
            //var_export(session('academia_set')->id);
            $academias = Academia::where('id', session('academia_set')->id)->get();
            $cliente = new Cliente();
            $method = 'POST';
            $actionUrl = route('clientes.store');            
            $submitButtonText = 'Crear Cliente';
            $alumnosPreSelected = $data['alumnosPreSelected'] ?? [];            
            $alumnosSelected = Alumno::whereHas('academiasRelation', function ($query) use ($academias) {
                 $query->whereIn('academiaid', $academias->pluck('id')->toArray());
                })
                ->select('alumnos.id', 'alumnos.nombre', 'alumnos.apellidos')
                ->distinct()
                ->get();
            //var_export($alumnosSelected);
            
        }       
        
        
        return [
            'cliente' => $cliente,
            'submitButtonText' => $submitButtonText,
            'actionUrl' => $actionUrl,
            'method' => $method,            
            'academiasSeleccionadas' => $data['academiasSeleccionadas'] ?? [],
            'alumnosSelected'=>$alumnosSelected ?? [],
            'alumnosPreSelected'=>$alumnosPreSelected ?? [],
            'academias' => $academias,            
            'data' => $data,
            'properties'=>$properties ?? [],
            'sidepanel' => $data['sidepanel'] ?? false,
        ];
    }

}