<?php

namespace App\Traits;

use App\Models\Academia;
use App\Models\Email;
use Illuminate\Support\Facades\Auth;

trait TraitFormPlantilla
{
    static function formularioPlantilla(array $data = []): array
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
                
        
        
        if(isset($data['email'])){ //EDICIÓN

            
            $email = $data['email'];            
            $method = 'PUT';
            $actionUrl = route('plantillas.update', $email->id);
            $submitButtonText = 'Actualizar Plantilla';

        }else{ //CREACIÓN
            
            $email = new Email();
            $method = 'POST';
            $actionUrl = route('plantillas.store');
            $submitButtonText = 'Crear Plantilla';
            $data['userid']=$user->id;
            $data['academiaid']=session('academia_set')->id;
        }
        
        
        $data['esplantilla']=1;
        return [
            'plantilla' => $email,
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