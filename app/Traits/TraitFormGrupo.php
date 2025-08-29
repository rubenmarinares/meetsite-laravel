<?php

namespace App\Traits;

use App\Models\Academia;
use App\Models\Aula;
use App\Models\Grupo;
use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;

trait TraitFormGrupo
{
    static function formularioGrupo(array $data = []): array
    {

        $academias = Academia::where('id', session('academia_set')->id)->get();       
        $aulas = Aula::whereHas('academiasRelation', function ($query) {
            $query->where('academiaid', session('academia_set')->id);
        })->get();

        $data["properties"] = $data["properties"] ?? [];
        if (is_string($data["properties"])) {            
            $properties = json_decode($data["properties"], true);
        } else {            
            $properties = $data["properties"]; // ya es array
        }
                        
        if(isset($data['grupo']) && $data['grupo'] instanceof Grupo && $data['grupo']->exists){ //EDICIÓN            
            $grupo = $data['grupo'];            
            $grupo->properties = json_decode($grupo->properties, true);
            $properties = array_merge($grupo->properties ?? [], $properties ?? []);

            $method = 'PUT';
            $actionUrl = route('grupos.update', $grupo->id);
            $submitButtonText = 'Actualizar Grupo';

            //FECHAS
            if (!empty($grupo->fechainicio)) {
                $grupo->fechainicio = Carbon::createFromFormat('Ymd', $grupo->fechainicio)->format('d/m/Y');                
            }
            if (!empty($grupo->fechafin)) {
                $grupo->fechafin = Carbon::createFromFormat('Ymd', $grupo->fechafin)->format('d/m/Y'); 
            }
                        
        }else{ //CREACIÓN
            $grupo = new Grupo();      
            //DEFAULT VALUES
            $defaults = Grupo::propertiesDefault();
            $data = array_merge($defaults, $data ?? []);             
            $method = 'POST';
            $actionUrl = route('grupos.store');            
            $submitButtonText = 'Crear Grupo';
        }
        
        return [
            'grupo' => $grupo,
            'submitButtonText' => $submitButtonText,
            'actionUrl' => $actionUrl,
            'method' => $method,            
            'academiasSeleccionadas' => $data['academiasSeleccionadas'] ?? [],            
            'academias' => $academias,
            'aulas' => $aulas,
            'data' => $data,
            'properties'=>$properties,
            'sidepanel' => $data['sidepanel'] ?? false,
        ];
    }

}