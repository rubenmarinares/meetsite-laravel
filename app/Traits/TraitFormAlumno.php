<?php

namespace App\Traits;

use App\Models\Academia;
use App\Models\Alumno;
use Illuminate\Support\Facades\Auth;

trait TraitFormAlumno
{
    static function formularioAlumno(array $data = []): array
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
                
          
        if(isset($data['alumno'])){ //EDICIÓN            
            
            $alumno = $data['alumno'];
            $alumno->fill([            
            'apellidos' => $data['apellidos'] ?? $alumno->apellidos,                
            ]);


            $method = 'PUT';
            $actionUrl = route('alumnos.update', $alumno->id);
            $submitButtonText = 'Actualizar Alumno';
        }else{ //CREACIÓN
            $alumno = new Alumno();
            $method = 'POST';
            $actionUrl = route('alumnos.store');
            $submitButtonText = 'Crear Alumno';
        }
        
        return [
            'alumno' => $alumno,
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