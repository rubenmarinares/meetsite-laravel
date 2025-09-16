<?php

namespace App\Traits;

use App\Traits\TraitFunctions;
use App\Models\Academia;
use App\Models\Alumno;
use App\Models\Aula;
use App\Models\Profesor;
use App\Models\Grupo;
trait TraitFormGrupo
{
    static function formularioGrupo(array $data = []): array
    {

        $academias = Academia::where('id', session('academia_set')->id)->get();       
        $aulas = Aula::whereHas('academiasRelation', function ($query) {
            $query->where('academiaid', session('academia_set')->id);
        })->get();

        $profesores = Profesor::whereHas('academiasRelation', function ($query) {
            $query->where('academiaid', session('academia_set')->id);
        })->get();

        $alumnos = Alumno::whereHas('academiasRelation', function ($query) {
            $query->where('academiaid', session('academia_set')->id);
        })
        ->orderBy('apellidos', 'asc')
        ->orderBy('nombre', 'asc')
        ->get();

        $data["properties"] = $data["properties"] ?? [];
        if (is_string($data["properties"])) {
            $properties=TraitFunctions::json_decode($data["properties"], true);
        } else {            
            $properties = $data["properties"]; // ya es array
        }
                 
        if(isset($data['grupo']) && $data['grupo'] instanceof Grupo && $data['grupo']->exists){ //EDICIÓN            
            $grupo = $data['grupo'];                        
            $grupo->properties = TraitFunctions::json_decode($grupo->properties, true);

            $properties = array_merge($grupo->properties ?? [], $properties ?? []);

            $method = 'PUT';
            $actionUrl = route('grupos.update', $grupo->id);
            $submitButtonText = 'Actualizar Grupo';

            //FECHAS
            $grupo->fechainicio = TraitFunctions::intToDate($grupo->fechainicio);
            $grupo->fechafin = TraitFunctions::intToDate($grupo->fechafin);            
                        
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
            'profesores' => $profesores,
            'alumnos' => $alumnos,
            'data' => $data,
            'properties'=>$properties,
            'sidepanel' => $data['sidepanel'] ?? false,
        ];
    }

}