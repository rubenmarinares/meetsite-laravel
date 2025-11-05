<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Grupo;
use App\Models\Alumno;
use App\Models\Profesor;
use App\Models\Asistencia;

use App\Traits\TraitFunctions;


class AsistenciaController extends Controller
{
    public function index(Request $request)
    {
        //$meses = TraitFunctions::meses();
        $idalumno = $request->input('idalumno');
        $idgrupo   = $request->input('idgrupo');
        $mes   = $request->input('mes');

        if($mes=='') $mes = (int) date('m');

        $alumnos = Alumno::whereHas('academiasRelation', function ($query)  {
                            $query->where('academiaid', session('academia_set')->id);
                        })->get();

        $grupos = Grupo::where('status',1)->
                    whereHas('academiasRelation',function($query){
                        $query->where('academiaid',session('academia_set')->id);
                    })->get();

        $actionUrl = route('asistencia.index');          
        return view('asistencia.index',[
            'alumnos'=>$alumnos,
            'grupos'=>$grupos,
            //'meses'=>$meses,  
            'selectedAlumno'=>$idalumno,            
            'selectedGrupo'=>$idgrupo,  
            'selectedMes'=>$mes,  
            'actionUrl'=>$actionUrl,
            'sidepanel'=>false,
        ]);
    }


    public function search(Request $request){

        
        


        //$mes      = $request->input('mes') ?? (int) date('m');
        $idgrupo  = $request->input('grupo');
        $idalumno = $request->input('idalumno');
        $fechadesde = $request->input('fechadesde'); // formato YYYYMMDD
        $fechahasta = $request->input('fechahasta'); // formato


        
        //Todos los alumnos de la academia

        if($idalumno=='') {
            $alumnos = Alumno::whereHas('academiasRelation', function ($query) {
                $query->where('academiaid', session('academia_set')->id);
            })
            ->orderBy('apellidos')->get();
        }else{
            $alumnos = Alumno::whereHas('academiasRelation',function($query) use($idalumno){
                        $query->where('academiaid',session('academia_set')->id);
                    })->where('id',$idalumno)
                    ->orderBy('apellidos', 'asc') 
                    ->get();

        }
            


        //PRIMERO EL GRUPO: Si no viene grupo, buscamos todos los grupos
        if($idgrupo==''){            
            $grupos = Grupo::where('status',1)->
                    whereHas('academiasRelation',function($query){
                        $query->where('academiaid',session('academia_set')->id);
                    })
                    ->orderBy('grupo', 'asc') 
                    ->get();            
        }else{
            $grupos = Grupo::where('status',1)->
                    whereHas('academiasRelation',function($query) use($idgrupo){
                        $query->where('academiaid',session('academia_set')->id);
                    })->where('id',$idgrupo)
                    ->orderBy('grupo', 'asc') 
                    ->get();
        }

        $anio = date('Y');        
        $fechaInicioMesSelected= (int)$fechadesde; // conviertes a DateTime
        $fechaFinMesSelected   = (int)$fechahasta;        

        $mesInicio = \DateTime::createFromFormat('Ymd', $fechaInicioMesSelected);
        $mesFin    = \DateTime::createFromFormat('Ymd', $fechaFinMesSelected);
        
        

        
        $gruposNew=array();


        foreach ($grupos as $grupo) {
            $arrayGrupos=array();
            if ($grupo["properties"] && strlen($grupo["fechainicio"]) > 0 && strlen($grupo["fechafin"]) > 0) {

                $addFechas=array();
                $properties = json_decode($grupo["properties"], true);
                
                if (!empty($properties["dias"])) {
                    $grupoInicio = \DateTime::createFromFormat('Ymd', $grupo["fechainicio"]);
                    $grupoFin    = \DateTime::createFromFormat('Ymd', $grupo["fechafin"]);

                    // comparar con timestamps
                    $inicio = ($grupoInicio->getTimestamp() > $mesInicio->getTimestamp()) ? clone $grupoInicio : clone $mesInicio;
                    $fin    = ($grupoFin->getTimestamp() < $mesFin->getTimestamp()) ? clone $grupoFin : clone $mesFin;            
                                        
                    if ($inicio > $fin) {                     
                        continue; 
                    }
                    
                    //BUSCAMOS LA ASISTENCIA PARA ESTE GRUPO CON LAS FECHA QEU TENEMOS
                    $asistencias = Asistencia::where('grupoid', $grupo->id)
                        ->whereBetween('fecha', [(int)$inicio->format('Ymd'), (int)$fin->format('Ymd')])
                        ->get(['grupoid as idgrupo', 'alumnoid as idalumno', 'fecha', 'estado'])
                        ->mapWithKeys(function($item) {
                            $key = $item->idgrupo . '_' . $item->idalumno . '_' . $item->fecha;
                            return [$key => [
                                'idgrupo'  => $item->idgrupo,
                                'idalumno' => $item->idalumno,
                                'fecha'    => $item->fecha,
                                'estado'    => $item->estado,
                            ]];
                        })
                        ->toArray();
                                        

                    while ($inicio <= $fin) {                                                                        
                        if(isset($properties["dias"][intval($inicio->format('N'))-1]) && $properties["dias"][intval($inicio->format('N'))-1]==1){                            
                            $addFechas[]=["fecha"=>$inicio->format('Y-m-d'),"dia"=>$inicio->format('N'),"dia_entero"=>(int)$inicio->format('Ymd')];
                        }                        
                        $inicio->modify('+1 day');
                    }
                    $addAlumnos=array();                    
                    if (!empty($properties["alumnos"])) {
                        foreach($properties["alumnos"] as $idalumno){
                            foreach($alumnos as $alumno){
                                if($alumno->id==$idalumno){
                                    $addAlumnos[]=["idalumno"=>$alumno->id,"nombre"=>$alumno->nombre,"apellidos"=>$alumno->apellidos];
                                    break;
                                }
                            }
                        }
                    }                    
                    $gruposNew[]=["grupo"=>$grupo->grupo,"idgrupo"=>$grupo->id,"fechas"=>$addFechas,"alumnos"=>$addAlumnos,"asistencias"=>$asistencias];
                }
            }
        }
       
      
        return response()->json($gruposNew);
    }

    public function update(Request $request)
        {
            // Ejemplo de validación
            $validated = $request->validate([
                'grupo'  => 'required|integer',
                'alumno' => 'required|integer',
                'fecha'  => 'required|digits:8|integer', // YYYYMMDD
                'estado' => 'required|integer|in:0,1,2',
            ]);

            Asistencia::updateOrCreate(
                [
                    'grupoid' => $validated['grupo'],
                    'alumnoid' => $validated['alumno'],
                    'fecha' => $validated['fecha'],
                ],
                [
                    'estado' => $validated['estado'],
                ]
            );


            return response()->json(['success' => true]);
        }

    public function comentario($grupo, $alumno, $fecha)
    {
        $asistencia = Asistencia::where('grupoid', $grupo)
                                ->where('alumnoid', $alumno)
                                ->where('fecha', $fecha)
                                ->first();


        if(!isset($asistencia)) {
            $asistencia = new Asistencia();
        }
        $comentario = '';
        if ($asistencia && $asistencia->properties) {
            $properties = json_decode($asistencia->properties, true);
            $comentario = $properties['comentario'] ?? '';    
        }
        


        return view('asistencia.partials.comentario_form', [
            'asistencia' => $asistencia,
            'grupo' => $grupo,
            'alumno' => $alumno,
            'fecha' => $fecha,
            'fechaEditada' => TraitFunctions::intToDate($fecha),
            'comentario' => $comentario
        ]);
    }

    public function guardarComentario(Request $request){
        $validated = $request->validate([
            'grupo' => 'required|integer',
            'alumno' => 'required|integer',
            'fecha' => 'required|digits:8',
            'comentario' => 'nullable|string|max:500',
        ]);


        $asistencia = Asistencia::firstOrCreate(
            [
                'grupoid' => $validated['grupo'],
                'alumnoid' => $validated['alumno'],
                'fecha'   => $validated['fecha'],
            ]
        );
        // Decodifica el campo properties (puede ser null o string vacío)
        $properties = $asistencia->properties ? json_decode($asistencia->properties, true) : [];

        // Guardamos/actualizamos el comentario dentro del JSON
        $properties['comentario'] = $validated['comentario'];

        // Reasignamos a la columna properties
        $asistencia->properties = json_encode($properties, JSON_UNESCAPED_UNICODE);
        $asistencia->save();

        return response()->json([
            'success' => true,
            'id' => $asistencia->id ?? null,
            'properties' => $properties,
        ]);
    }
        

   
}
