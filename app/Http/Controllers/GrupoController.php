<?php


namespace App\Http\Controllers;

use App\Http\Requests\GrupoRequest;
use App\Models\Grupo;
use App\Models\Academia;
use Illuminate\Http\Request;

use Illuminate\Http\RedirectResponse;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;


use Illuminate\Support\Facades\DB;


use App\Traits\TraitFormGrupo;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

use App\Traits\TraitFunctions;

class GrupoController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Grupo::class,'grupo');       
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        

        $grupos = Grupo::whereHas('academiasRelation', function ($query) {
            $query->where('academiaid', session('academia_set')->id);
        })
        ->orderBy('grupo')
        ->get();

        return view('grupos.index',[
            'grupos'=>$grupos,
            'emptyMessage'=>'No hay Grupos registrados',
            'sidepanel'=>false,
        ]);
    }

    public function create():View{
        $vars = TraitFormGrupo::formularioGrupo();
        $var['sidepanel']=request('sidepanel', false);
        return view('grupos.create', $vars);        
    }

    public function store(GrupoRequest $request){
        
        try {
            DB::beginTransaction();
            $validated=($request->validated());
            $validated["properties"] =TraitFunctions::json_encode($request["properties"]);            
            //FECHAS
            $validated["fechainicio"] = TraitFunctions::dateToInt($validated["fechainicio"]);
            $validated["fechafin"] = TraitFunctions::dateToInt($validated["fechafin"]);

            
                            
            $grupo=Grupo::create($validated);
            $grupo->academiasRelation()->sync($request['academias'] ?? []); // si no vienen, se limpia la relación              
            DB::commit();
            $successMessages = [            
                'Grupo creado con éxito.'
            ];    
            session()->flash('success_messages', $successMessages);
        } catch (\Exception $e) {
            DB::rollBack(); // Revierte todo
            session()->flash('error_messages', [
                "Error al crear el recurso.",
                $e->getMessage()
            ]);
        }        
    }

    public function edit(Grupo $grupo) : View{
        
        $var['sidepanel']=request('sidepanel', false);
        //$var['sidepanel']=false;
        $var['grupo']=$grupo;
        $var['academiasSeleccionadas']=$grupo->academiasRelation->pluck('id')->toArray();

        $vars = TraitFormGrupo::formularioGrupo($var);

        return view('grupos.edit', $vars);        
    }

    //ACTUALIZAR RECURSO
    public function update(GrupoRequest $request,Grupo $grupo){
        try {
            DB::beginTransaction();            
            $validated=($request->validated());
            //$validated["properties"] = json_encode($request["properties"]);
            $validated["properties"] =TraitFunctions::json_encode($request["properties"]);

            //FECHAS
            $validated["fechainicio"] = TraitFunctions::dateToInt($validated["fechainicio"]);
            $validated["fechafin"] = TraitFunctions::dateToInt($validated["fechafin"]);

            $grupo->update($validated);
            $grupo->academiasRelation()->sync($request['academias'] ?? []);
            //throw new \Exception("Error forzado para probar el catch");
            DB::commit();            
            $successMessages = ['Grupo actualizado con éxito.'];
            session()->flash('success_messages', $successMessages);            

        } catch (\Exception $e) {
            DB::rollBack(); // Revierte todo
            session()->flash('error_messages', [
                "Error al actualizar el recurso.",
                $e->getMessage()
            ]);
        }        
    }


    public function destroy(Request $request, Grupo $grupo):RedirectResponse{   
    
     try {
            DB::beginTransaction();

            $grupo->delete();
            //throw new \Exception("Forzando error para probar el catch");
            DB::commit();
            $successMessages = [            
                'Grupo eliminada con éxito.'
            ];
            session()->flash('success_messages', $successMessages);            

        } catch (\Exception $e) {
            DB::rollBack(); // Revierte todo
            session()->flash('error_messages', [
                "Error al eliminar el recurso.",
                $e->getMessage()
            ]);
            
            
        }   

        $redirectUrl = $request->input('redirect_to', route('grupos.index'));
        $redirectUrl = URL::to($redirectUrl) . (Str::contains($redirectUrl, '?') ? '&' : '?') . 'tab=6';
        return redirect()->to($redirectUrl);
    }

}
