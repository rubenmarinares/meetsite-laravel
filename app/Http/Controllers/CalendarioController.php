<?php

namespace App\Http\Controllers;


use App\Models\Grupo;
use App\Models\Profesor;
use App\Models\Alumno;
use App\Models\Aula;

use Illuminate\Http\Request;

use Carbon\Carbon;

class CalendarioController extends Controller
{
    public function index()
    {                
        return view('calendario.index', []);
    }

    // Si usas FullCalendar o similar, quizás necesites un endpoint JSON:
    public function events()
    {
       $grupos = Grupo::whereHas('academiasRelation', function ($query) {
            $query->where('academiaid', session('academia_set')->id);
            })
            ->orderBy('grupo')->get();
            
        $aulas=Aula::whereHas('academiasRelation', function ($query) {
            $query->where('academiaid', session('academia_set')->id);
            })
            ->orderBy('aula')->get();
                
        $profesores=Profesor::whereHas('academiasRelation', function ($query) {
            $query->where('academiaid', session('academia_set')->id);
            })
            ->orderBy('apellidos')->get();

        $alumnos=Alumno::whereHas('academiasRelation', function ($query) {
            $query->where('academiaid', session('academia_set')->id);
            })
            ->orderBy('apellidos')->get();

        
        $events=[];
        if($grupos->isEmpty()){
            return response()->json([]); 
        }else{
            foreach($grupos as $grupo){
                if($grupo["properties"] && (strlen($grupo["fechainicio"])>0 && strlen($grupo["fechafin"]>0)) ){
                    $properties=json_decode($grupo["properties"],true);
                    if($properties["dias"]){
                        foreach($properties["dias"] as $key=>$dia){

                            $inicio = \DateTime::createFromFormat('Ymd', $grupo["fechainicio"]);
                            $fin = \DateTime::createFromFormat('Ymd', $grupo["fechafin"]);
                            
                            
                            //echo "Grupo: ".$grupo['grupo']."<br>";
                            while ($inicio <= $fin) {
                                $event=[];
                                if (in_array($inicio->format('N'), [intval($key+1)])) { // N devuelve el número del día (1=Lunes, 7=Domingo)                                
                                    $horarioinicio="";
                                    if(strlen($properties["hora_ini"][$key])>0){
                                        $horarioinicio=$properties["hora_ini"][$key].":00";                                        
                                    }else{
                                        $horarioinicio="00:00:00";
                                    }
                                    $horariofin="";
                                    if(strlen($properties["hora_fin"][$key])>0){
                                        $horariofin=$properties["hora_fin"][$key].":00";                                        
                                    }else{
                                        $horariofin="23:59:59";
                                    } 
                                    
                                    
                                    
                                    $event["start"]=$inicio->format('Y-m-d')."T".$horarioinicio;
                                    $event["end"]=$inicio->format('Y-m-d')."T".$horariofin;
                                    $event["hora_ini"]=intval($properties["hora_ini"][$key]);                                
                                    $event["hora_fin"]=intval($properties["hora_fin"][$key]);                                
                                    //$event["profesor"]=$properties["profesor"][$key];                                
                                    //$event["aula"]=$properties["aula"][$key];
                                    $event["idgrupo"]=$grupo["id"];
                                    $event["title"]=$grupo["grupo"];
                                    $event["color"]=$grupo["color"];
                                    $event["backgroundColor"]=$grupo["color"];
                                    $event["textColor"]=$grupo["textcolor"]; 
                                    //$event["idacademia"]=$item["academiaid"]; 

                                    //Obtenemos aula
                                    $labelAula=array();
                                    if(intval($properties["aula"][$key])>0){
                                        $idaula=intval($properties["aula"][$key]);                                        
                                        $labelAula = $aulas->filter(function($aula) use ($idaula) {
                                            return $aula->id == $idaula;
                                        });                                                                                                                                                              
                                    }

                                    if($labelAula){
                                        $labelAula=$labelAula->first()->toArray();
                                    }

                                    $labelProfesor=array();
                                    if(isset($properties["profesor"]) && intval($properties["profesor"])>0){
                                        $idprofesor=intval($properties["profesor"]);                                        
                                        $labelProfesor = $profesores->filter(function($profesor) use ($idprofesor) {
                                            return $profesor->id == $idprofesor;
                                        });                                                                                                                                                              
                                    }
                                     
                                    if($labelProfesor){
                                        $labelProfesor=$labelProfesor->first()->toArray();
                                    }


                                    $event["description"]='
                                    <div class="row">
                                        <h6 class="d-flex">'.$grupo["grupo"].' <small class="ms-auto"><i class="fa fa-calendar" aria-hidden="true"></i> '.$inicio->format('d-m-Y').' ('.substr($horarioinicio, 0, 5).'-'.substr($horariofin, 0, 5).')</small></h6>
                                        <div class="col-12">
                                            <div class="row">
                                                '.(isset($labelAsignatura["asignatura"])?
                                                        '<div class="col-12">
                                                                <strong>Asignatura:</strong> '.$labelAsignatura["asignatura"].' 
                                                        </div>':'').'
                                                '.(isset($labelProfesor["nombre"])?
                                                        '<div class="col-12">
                                                                <strong>Profesor:</strong> '.$labelProfesor["nombre"].' '.$labelProfesor["apellidos"].' 
                                                        </div>':'').'
                                                '.(isset($labelAula["aula"])?'
                                                        <div class="col-12">
                                                                <strong>Aula:</strong> '.$labelAula["aula"].'
                                                        </div>':'').'                                                
                                                                                                                                     
                                            </div>
                                    </div>';
                                    
                                    //var_dump($event);
                                    $events[]=$event;    
                                }

                                $inicio->modify('+1 day');
                            }                            
                        }
                    }
                }
            }

        }
        
        //dd($grupos,$profesores,$alumnos);

/*
$eventos = [
    [
        'title' => 'Clase de Matemáticas',
        'start' => '2025-09-01T10:00:00',
        'end'   => '2025-09-01T12:00:00',
        'color' => '#1e90ff',
        'textColor' => '#ffffff', // Color del texto
        'description' => 'Clase de matemáticas avanzada.', // Descripción adicional
    ],
    [
        'title' => 'Clase de Matemáticas',
        'start' => '2025-09-01T10:00:00',
        'end'   => '2025-09-01T12:00:00',
        'color' => 'red',
        'textColor' => '#ffffff', // Color del texto
        'description' => 'Clase de matemáticas avanzada.', // Descripción adicional
    ],
    [
        'title' => 'Inglés - Grupo A',
        'start' => '2025-09-02T09:30:00',
        'end'   => '2025-09-02T11:00:00',
        'color' => '#28a745',
        'textColor' => '#ffffff', // Color del texto
        'description' => 'Clase de inglés para principiantes.', // Descripción adicional
    ],
    [
        'title' => 'Historia - Aula 3',
        'start' => '2025-09-03T15:00:00',
        'end'   => '2025-09-03T16:30:00',
        'color' => '#ffc107',
        'description' => 'Clase especial sobre la Revolución Francesa.', // Descripción adicional
    ],
    [
        'title' => 'Reunión de profesores',
        'start' => '2025-09-05T12:00:00',
        'end'   => '2025-09-05T13:00:00',
        'color' => '#dc3545',
        'description' => 'Reunión mensual para discutir el progreso de los estudiantes.', // Descripción adicional
    ],
    [
        'title' => 'Cierre de inscripciones',
        'start' => '2025-09-07', // Evento de día completo
        'color' => '#6f42c1',
        'allDay' => true,
        'description' => 'Último día para inscribirse en los cursos.', // Descripción adicional
    ],
];
*/

        return response()->json($events);
    }
}
