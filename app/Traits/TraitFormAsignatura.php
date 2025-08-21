<?php

namespace App\Traits;

use App\Models\Academia;
use App\Models\Asignatura;
use Illuminate\Support\Facades\Auth;

trait TraitFormAsignatura
{
    static function formularioAsignatura(array $data = []): array
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
            
                
        if(isset($data['asignatura']) && $data['asignatura'] instanceof Asignatura && $data['asignatura']->exists){ //EDICIÓN            
            
            $asignatura = $data['asignatura'];
            $method = 'PUT';
            $actionUrl = route('asignaturas.update', $asignatura->id);
            $submitButtonText = 'Actualizar Asignatura';
        }else{ //CREACIÓN
            $asignatura = new Asignatura();
            $method = 'POST';
            $actionUrl = route('asignaturas.store');
            $submitButtonText = 'Crear Asignatura';
        }
        
        return [
            'asignatura' => $asignatura,
            'submitButtonText' => $submitButtonText,
            'actionUrl' => $actionUrl,
            'method' => $method,            
            'academiasSeleccionadas' => $data['academiasSeleccionadas'] ?? [],
            'academias' => $academias,            
            'data' => $data,
            'sidepanel' => $data['sidepanel'] ?? false,
        ];
    }

}