<?php

namespace App\Traits;

use App\Models\Academia;
use App\Models\Aula;
use Illuminate\Support\Facades\Auth;

trait TraitFormAula
{
    static function formularioAula(array $data = []): array
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
            
        //var_dump($data["properties"]);
        if(isset($data['aula']) && $data['aula'] instanceof Aula && $data['aula']->exists){ //EDICIÓN            
            
            $aula = $data['aula'];
            $properties=json_decode($aula["properties"],true);
            $method = 'PUT';
            $actionUrl = route('aulas.update', $aula->id);
            $submitButtonText = 'Actualizar Aula';
            //$properties=json_decode($aula["properties"],true);
        }else{ //CREACIÓN
            $aula = new Aula();
            $method = 'POST';
            $actionUrl = route('aulas.store');
            $properties=Aula::propertiesDefault();
            $submitButtonText = 'Crear Aula';
        }        
        return [
            'aula' => $aula,
            'submitButtonText' => $submitButtonText,
            'actionUrl' => $actionUrl,
            'method' => $method,            
            'academiasSeleccionadas' => $data['academiasSeleccionadas'] ?? [],
            'academias' => $academias,            
            'data' => $data,
            'properties'=>$properties ?? [],
            'sidepanel' => $data['sidepanel'] ?? false,
        ];
    }

}