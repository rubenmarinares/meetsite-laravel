<?php

namespace App\Traits;

use App\Models\Academia;
use App\Models\Profesor;
use Illuminate\Support\Facades\Auth;

trait TraitFormProfesor
{
    static function formularioProfesor(array $data = []): array
    {


        $user = Auth::user();
        if ($user->hasRole('super-admin')) {
            $academias = Academia::query()->orderByRaw('academia')->get();
            $menu = true;
        } else {
            $academias = Academia::query()
                ->whereHas('users', function ($query) use ($user) {
                    $query->where('users.id', $user->id);
                })
                ->orderByRaw('academia')->get();
            $menu = false;
        }
                

        if(isset($data['profesor'])){ //EDICIÓN            
            
            $profesor = $data['profesor'];
            $profesor->fill([            
            'apellidos' => $data['apellidos'] ?? $profesor->apellidos,
                // añade más campos según el modelo
            ]);


            $method = 'PUT';
            $actionUrl = route('profesores.update', $profesor->id);
            $submitButtonText = 'Actualizar Profesor';
        }else{ //CREACIÓN
            $profesor = new Profesor();
            $method = 'POST';
            $actionUrl = route('profesores.store');
            $submitButtonText = 'Crear Profesor';
        }
        
        return [
            'profesor' => $profesor,
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