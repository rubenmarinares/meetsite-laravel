<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlantillaRequest;
use App\Models\Email;
use App\Models\Section;
use App\Models\EmailSection;
use App\Models\EmailBlock;
use App\Models\Block;

use Illuminate\Http\Request;

use Illuminate\Http\RedirectResponse;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;


use App\Traits\TraitFormPlantilla;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Mail;
use App\Mail\CustomHtmlEmail;

class EmailController extends Controller
{
    //

     /* public function __construct()
    {
        $this->authorizeResource(Email::class,'email');       
    }*/



     public function index()
    {                    
        $plantillas = Email::where('academiaid', session('academia_set')->id)
                    ->where('plantilla', 1)
                    ->get();

        
        return view('plantillas.index',[
            'plantillas' => $plantillas, 
            'emptyMessage'=>'No hay plantillas registradas',
            'sidepanel'=>false
        ]);
    }


    public function edit(Email $plantilla) : View{        
        $var['sidepanel']=request('sidepanel', false);
        $var['email']=$plantilla;
        
        $vars = TraitFormPlantilla::formularioPlantilla($var);
        return view('plantillas.edit', $vars);
    }


    public function create():View{
        $vars = TraitFormPlantilla::formularioPlantilla();        
        return view('plantillas.create', $vars);        
    }


    public function store(PlantillaRequest $request){

        try {
            DB::beginTransaction();
            $validated=($request->validated());
                           
            $plantilla=Email::create($validated);            
            DB::commit();
            $successMessages = [            
                'Plantilla creada con éxito.'
            ];    
            session()->flash('success_messages', $successMessages);
        } catch (\Exception $e) {
            DB::rollBack(); 
            session()->flash('error_messages', [
                "Error al crear el recurso.",
                $e->getMessage()
            ]);
        }        
    }



    public function update(PlantillaRequest $request,Email $plantilla){
            try {
                DB::beginTransaction();

                //$redirectUrl = $request->input('redirect_to', route('profesores.index'));
                $validated=($request->validated());
                $plantilla->update($validated);                
        
                //throw new \Exception("Error forzado para probar el catch");
                DB::commit();            
                $successMessages = ['Plantilla actualizada con éxito.'];
                session()->flash('success_messages', $successMessages);            

            } catch (\Exception $e) {
                DB::rollBack(); // Revierte todo
                session()->flash('error_messages', [
                    "Error al actualizar el recurso.",
                    $e->getMessage()
                ]);
            }        
        }


    public function editsection($section) : View{
        
        //echo "Section: ".$section."<br>";
        $objSection = EmailSection::select(
                'email_sections.*',
                'sections.numcols',
                'sections.properties as properties_origen' // 👈 alias personalizado
            )
            ->join('sections', 'sections.id', '=', 'email_sections.sectionid')
            ->where('email_sections.id', $section)
            ->first();
            //->toArray();
        //dd($objSection);        
        $properties=json_decode($objSection->properties,true);

        var_export($properties);
        



        return view('plantillas.secciones.edit', [  'section'=>$section,
                                                    'actionUrl'=>route('plantillas.updatesection',['section'=>$section]),
                                                    'method'=>'PUT',
                                                    'properties'=>$properties,
                                                    'submitButtonText'=>'Guardar cambios',
                                                    'numcols'=>$objSection->numcols,
                                                ]);
    }


    public function updatesection(Request $request, $section){
        $validated = $request->validate([
            'properties' => 'required|array',
        ]);                        
        try {
            DB::beginTransaction();
            $emailSection = EmailSection::find($section);
            $emailSection->properties = json_encode($validated['properties']);
            $emailSection->save();
                        
            DB::commit();            
            $successMessages = ['Sección actualizada con éxito.'];
            session()->flash('success_messages', $successMessages);            

        } catch (\Exception $e) {
            DB::rollBack(); // Revierte todo
            session()->flash('error_messages', [
                "Error al actualizar la sección.",
                $e->getMessage()
            ]);
        }        
    }


    public function editBlock($block) : View{
                
        $objBlock = EmailBlock::select(
                'email_blocks.*',                
                'blocks.properties as properties_origen',
                'blocks.type'

            )
            ->join('blocks', 'blocks.id', '=', 'email_blocks.blockid')
            ->where('email_blocks.id', $block)
            ->first();
            //->toArray();
            //dd($objSection);        

        $properties=json_decode($objBlock->properties,true);

        $fontFamily=array("Arial","Verdana","Helvetica","Georgia","Tahoma","Lucida","Trebuchet","Times");
        $fontStyle=array("Normal","Italic","Bold","Bold Italic");

        var_export($properties);
        return view('plantillas.bloques.edit', ['block'=>$block,
                                                'actionUrl'=>route('plantillas.updateblock',['block'=>$block]),
                                                'method'=>'PUT',
                                                'properties'=>$properties,
                                                'typeblock'=>$objBlock->type,
                                                'submitButtonText'=>'Guardar cambios',
                                                'fontFamily'=>$fontFamily,
                                                'fontStyle'=>$fontStyle,
                                                'submitButtonText'=>'Guardar cambios',
                                                ]);
        /*
        $properties=json_decode($objblock->properties,true);

        var_export($properties);

        */
    }


    public function updateblock(Request $request, $block){

        //var_dump($request);        
        $validated = $request->validate([
            'properties' => 'required|array',
            'uploadfile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096'
        ]);           

        /*if ($request->hasFile('uploadfile')) {
            $file = $request->file('uploadfile');
            
            // Crear un nombre único para el archivo
            $filename = 'image_' . now()->format('YmdHis') . '.' . $file->getClientOriginalExtension();

            // Guardar el archivo en storage/app/public/uploads
            $path = $file->storeAs('uploads', $filename, 'public');
            $url = asset('storage/' . $path);
            $validated['properties']['imageurl'] = $url;            
        }
        */

        if ($request->hasFile('uploadfile')) {
            $file = $request->file('uploadfile');
            $filename = 'image_' . date('YmdHis') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/emails/'), $filename);

            $url = asset('uploads/emails/' . $filename);
            $validated['properties']['imageurl'] = $url;
        }
        

        
        
        

        //var_export($validated['properties']);
            

        
        try {
            DB::beginTransaction();
            $emailBlock = EmailBlock::find($block);
            $emailBlock->properties = json_encode($validated['properties']);
            $emailBlock->save();
                        
            DB::commit();            
            $successMessages = ['Bloque actualizado con éxito.'];
            session()->flash('success_messages', $successMessages);            

        } catch (\Exception $e) {
            DB::rollBack(); // Revierte todo
            session()->flash('error_messages', [
                "Error al actualizar el bloque.",
                $e->getMessage()
            ]);
        }        
    }





    public function destroy(Request $request, Email $plantilla):RedirectResponse{   
    
    
     try {
            DB::beginTransaction();

            $plantilla->delete();
            //throw new \Exception("Forzando error para probar el catch");
            DB::commit();
            $successMessages = [            
                'Plantilla eliminada con éxito.'
            ];
            session()->flash('success_messages', $successMessages);            

        } catch (\Exception $e) {
            DB::rollBack(); // Revierte todo
            session()->flash('error_messages', [
                "Error al eliminar el recurso.",
                $e->getMessage()
            ]);
            
            
        }   

        $redirectUrl = $request->input('redirect_to', route('plantillas.index'));
        $redirectUrl = URL::to($redirectUrl) . (Str::contains($redirectUrl, '?') ? '&' : '?') . 'tab=20';
        return redirect()->to($redirectUrl);
    }


    public function config(Email $plantilla) : View{            
        $sections=Section::where('status',1)->orderBy('order')->get();
        $blocks=Block::where('status',1)->orderBy('order')->get();

        $previewUrl=route('plantillas.renderemail',$plantilla);
        return view('plantillas.config', ['sections'=>$sections,'blocks'=>$blocks,'previewUrl'=>$previewUrl,'idemail'=>$plantilla->id]);
    }


    public function sendTestEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'id' => 'required|integer|exists:emails,id' // o la tabla que corresponda
        ]);

        $to = $request->input('email');
        $id = $request->input('id');

        // Aquí recuperas la plantilla
        $plantilla = Email::findOrFail($id);

                         
        $subject = 'Test Meetsite';
        $html = $this->renderEmail($id)->getContent();

        Mail::to($to)->send(new CustomHtmlEmail($subject, $html));
        
        return response()->json([
            'success' => true,
            'message' => "El test se ha enviado correctamente a {$to}."
        ]);
    }


    public function cloneBlock(Request $request, $block){
        try {
            DB::beginTransaction();

            $originalBlock = EmailBlock::find($block);
            $clonedBlock = $originalBlock->replicate();
            $clonedBlock->save();

            DB::commit();
            return response()->json([
                'status' => 'success',
                'data' => $clonedBlock
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Error al clonar el bloque: ' . $e->getMessage()
            ], 500);
        }
    }

    public function storeblock(Request $request,$plantilla){

        //var_export($request);
        //dd($request);


        $validated = $request->validate([
            'sectionid' => 'required|integer',
            'blockid' => 'required|integer|exists:blocks,id',
            'col' => 'required|integer',
            'order' => 'nullable|integer'
        ]);        
        //$section = Section::where('id', $validated['sectionid'])  ->get();
        $block = Block::find($validated['blockid']);

        // Creamos el registro en la tabla pivot email_sections
        $emailBlock = EmailBlock::create([            
            'sectionid' => $validated['sectionid'],
            'blockid' => $validated['blockid'],
            'col' => $validated['col'],
            'order' => $validated['order'] ?? 0,
            'properties' => $block->properties
        ]);

        return response()->json([
            'status' => 'success',
            'data' => $emailBlock
        ]);


    }
    




    //ADMIN SECTIONS
    public function storesection(Request $request, $plantilla){                    
        $validated = $request->validate([
            'sectionid' => 'required|integer|exists:sections,id',
            'order' => 'nullable|integer'
        ]);        
        //$section = Section::where('id', $validated['sectionid'])  ->get();
        $section = Section::find($validated['sectionid']);

                
        // Creamos el registro en la tabla pivot email_sections
        $emailSection = EmailSection::create([
            'emailid' => $plantilla,  // el ID del email viene en la URL
            'sectionid' => $validated['sectionid'],
            'order' => $validated['order'] ?? 0,
            'properties' => $section->properties
        ]);

        return response()->json([
            'status' => 'success',
            'data' => $emailSection
        ]);
    }



    //REORDENAR SECCIONES
    public function ordenarSecciones(Request $request, $plantilla){

        $newOrder = $request->input('neworder');
        
        if (!is_array($newOrder)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Formato de orden no válido'
            ], 400);
        }

        DB::beginTransaction();

        try {
            foreach ($newOrder as $index => $id) {
                if ($id !== null && $id !== 'undefined') {
                    EmailSection::where('id', intval($id))
                        ->where('emailid', $plantilla)
                        ->update(['order' => intval($index)]);
                }
            }
            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Orden actualizado correctamente'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => 'Error al actualizar el orden: ' . $e->getMessage()
            ], 500);
        }
    }


    //ELiminar secciones
    public function deleteSection($plantilla, $sectionId){
    // Buscar la sección dentro del email específico
        $section = EmailSection::where('emailid', $plantilla)
            ->where('id', $sectionId)
            ->first();

        if (!$section) {
            return response()->json([
                'status' => 'error',
                'message' => 'Sección no encontrada'
            ], 404);
        }
    
        $section->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Sección eliminada correctamente'
        ]);
    }


    public function deleteBlock($plantilla, $blockid){        
                
        $block = EmailBlock::where('id', $blockid)            
            ->first();

        if (!$block) {
            return response()->json([
                'status' => 'error',
                'message' => 'Bloque no encontrado'
            ], 404);
        }
    
        $block->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Bloque eliminado correctamente'
        ]);
        
    }



public function ordenarBloques(Request $request, $plantilla)
{
    $validated = $request->validate([
        'neworder' => 'required|array',
        'sectionidFrom' => 'required|integer',
        'sectionidTo' => 'required|integer',
        'col' => 'required|integer',
    ]);

    $neworder = $validated['neworder'];
    $sectionidFrom = $validated['sectionidFrom'];
    $sectionidTo = $validated['sectionidTo'];
    $colTo = $validated['col'];

    DB::transaction(function () use ($neworder, $sectionidFrom, $sectionidTo, $colTo) {

        // 🟩 1️⃣ Si la sección destino es distinta, actualizamos la relación del bloque
        if ($sectionidFrom !== $sectionidTo) {
            // Actualizamos los bloques que se movieron de sección
            EmailBlock::whereIn('id', $neworder)->update([
                'sectionid' => $sectionidTo,
                'col' => $colTo
            ]);
        }

        // 🟦 2️⃣ Reordenamos los bloques del destino
        foreach ($neworder as $position => $blockId) {
            EmailBlock::where('id', $blockId)->update([
                'order' => $position,
                'sectionid' => $sectionidTo,
                'col' => $colTo
            ]);
        }

        // 🟥 3️⃣ Reordenamos los bloques del origen (solo si cambia de columna o sección)
        if ($sectionidFrom !== $sectionidTo) {
            $bloquesFrom = EmailBlock::where('sectionid', $sectionidFrom)
                ->orderBy('order')
                ->get();

            foreach ($bloquesFrom as $index => $bloque) {
                $bloque->update(['order' => $index]);
            }
        }
    });

    return response()->json([
        'status' => 'success',
        'message' => 'Orden de bloques actualizado correctamente'
    ]);
}


public function moverBloques(Request $request, $plantilla)
{
    $validated = $request->validate([
        'neworder' => 'required|array',       // destino
        'neworderFrom' => 'required|array',   // origen
        'sectionidFrom' => 'required|integer',
        'sectionidTo' => 'required|integer',
        'col' => 'required|integer',
    ]);

    DB::transaction(function () use ($validated) {
        $sectionidFrom = $validated['sectionidFrom'];
        $sectionidTo = $validated['sectionidTo'];
        $colTo = $validated['col'];

        // Actualizar columna y sección de los bloques movidos
        EmailBlock::whereIn('id', $validated['neworder'])->update([
            'sectionid' => $sectionidTo,
            'col' => $colTo,
        ]);

        // Reordenar destino
        foreach ($validated['neworder'] as $index => $blockId) {
            EmailBlock::where('id', $blockId)->update(['order' => $index]);
        }

        // Reordenar origen
        foreach ($validated['neworderFrom'] as $index => $blockId) {
            EmailBlock::where('id', $blockId)->update(['order' => $index]);
        }
    });

       return response()->json([
        'status' => 'success',
        'message' => 'Bloques movidos y reordenados correctamente',
    ]);
}




public function renderEmail($plantilla)
{
    $sections = EmailSection::with(['section', 'blocks.block'])
        ->where('emailid', $plantilla)
        ->orderBy('order')
        ->orderBy('id')
        ->get();

    $renderedSections = [];

    foreach ($sections as $section) {
        $properties_row = json_decode($section->properties, true);
        $rowHtml = $this->renderRow((int) $section->section->numcols, $properties_row);
        $sectionHtml = $rowHtml['html'];

        for ($i = 1; $i <= (int) $section->section->numcols; $i++) {
            $colHtml = '';
            if ($section->blocks) {
                foreach ($section->blocks as $block) {
                    if ($block->col == $i && $section->id == $block->sectionid) {
                        $properties_block = json_decode($block->properties, true);
                        $blockhtml = $this->renderBlock(
                            $properties_block,
                            $block->block->type,
                            $block->col,
                            $properties_block,
                            false,
                            $rowHtml['width'][$i] ?? '',
                            0
                        );
                        $colHtml .= $blockhtml;
                    }
                }
            }
            $sectionHtml = str_replace("@@col{$i}_blocks@@", $colHtml, $sectionHtml);
        }

        $renderedSections[] = [
            'id' => $section->id,
            'html' => $sectionHtml,
        ];
    }

    // Cargar estilos adicionales desde un archivo opcional (puede estar vacío)
    $stylesPath = resource_path('views/emails/styles.css');
    $styles = file_exists($stylesPath) ? file_get_contents($stylesPath) : '';

    return response()
        ->view('plantillas.render', [
            'sections' => $renderedSections,
            'styles' => $styles,
        ], 200)
        ->header('Content-Type', 'text/html');
}


public function getSections($plantilla){
        
        $sections = EmailSection::with([
            'section',        // relación con Section
            'blocks.block'    // relación con EmailBlock + Block
        ])
        ->where('emailid', $plantilla)
        ->orderBy('order')
        ->orderBy('id')
        ->get();

        foreach($sections as $section){
            $properties_row=json_decode($section->properties,true);                        
            $rowHtml=$this->renderRow(intval($section->section->numcols),$properties_row);
            
            $html = $rowHtml['html'];
            
            for ($i = 1; $i <= intval($section->section->numcols); $i++) {
                $html = str_replace("@@col{$i}_blocks@@",'<div id="section'.$section->id.'-col'.$i.'" class="RowBlocks" data-idsection="'.$section->id.'" data-col="'.$i.'">@@col'.$i.'_blocks@@</div>',$html);
                $colHtml='';
                if($section->blocks){
                    foreach($section->blocks as $block){
                        if($block->col == $i && $section->id==$block->sectionid ){                             
                            $properties_block=json_decode($block->properties,true);                                                        
                            $blockhtml=$this->renderBlock($properties_block,$block->block->type,$block->col,$properties_block,false,(isset($rowHtml["width"][$i]) ? $rowHtml["width"][$i] : ''),0 );
                            $colHtml.='
                                        <div class="block position-relative border rounded mb-2 bg-white shadow-sm" 
                                            id="block-'.$block->id.'" 
                                            data-typeblock="'.$block->type.'" 
                                            data-idblock="'.$block->id.'">

                                            <div class="blocktoolbar position-absolute">
                                                <div class="btn-group" role="group" aria-label="Toolbar actions">
                                                    <span id="deleteblock-'.$block->id.'" >
                                                    <a href="#" onclick="confirmDeleteBlock('.$block->id.'); return false;" 
                                                                class="btn btn-sm btn-light btn-outline-danger " 
                                                                title="Eliminar bloque">
                                                                <i class="fas fa-trash"></i>
                                                    </a>
                                                    </span>
                                                    <a href="#" onclick="cloneBlock('.$block->id.'); return false;" 
                                                                class="btn btn-sm btn-light " 
                                                                title="Clonar bloque">
                                                                <i class="fas fa-clone"></i>
                                                    </a>
                                                    <a href="'.route('plantillas.editblock',['block'=>$block->id,'sidepanel'=>true]).'""  
                                                            class="btn btn-sm btn-light ajax-sidepanel" 
                                                            title="Editar bloque">
                                                            <i class="fas fa-pencil-alt"></i>
                                                    </a>
                                                    <a href="#" class="btn btn-sm btn-light  handle" 
                                                        onclick="event.preventDefault();" 
                                                        title="Mover bloque">
                                                        <i class="fas fa-arrows-alt-v"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="blockinner" id="blockinner-'.$block->id.'">'.$blockhtml.'</div>
                                        </div>';
                        }

                    }   
                }

                $html=str_replace("@@col".$i."_blocks@@",$colHtml,$html);            
            }
                        

            //$urlSectionEdit=route('plantillas.editsections',['plantilla'=>$plantilla,'section'=>$section->id,'sidepanel'=>true]);
            $html='<div class="rowdiv position-relative border rounded bg-light shadow-sm" 
                            id="section-'.$section->id.'" 
                            data-typerow="'.$section->id.'" 
                            data-idsection="'.$section->id.'" 
                            data-idtyperow="'.$section->id.'">

                            <div class="rowtoolbar position-absolute">
                                 <div class="btn-group" role="group" aria-label="Toolbar actions">
                                    <span id="deletesection-'.$section->id.'" >
                                    <a href="#" onclick="confirmDeleteSection('.$section->id.'); return false;" 
                                    class="btn btn-sm btn-light btn-outline-danger" 
                                    title="Eliminar sección">
                                    <i class="fas fa-trash"></i>
                                    </a>
                                    </span>
                                    <a href="'.route('plantillas.editsection',['section'=>$section->id,'sidepanel'=>true]).'" 
                                    class="btn btn-sm btn-light ajax-sidepanel" 
                                    title="Editar sección">
                                    <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <a href="#" class="btn btn-sm btn-light  handle" 
                                    onclick="event.preventDefault();" 
                                    title="Mover sección">
                                    <i class="fas fa-arrows-alt-v"></i>
                                    </a>
                                  </div>  
                            </div>

                            <div class="rowinner" id="rowinner-'.$section->id.'" style="width:800px;">'.$html.'</div>
                        </div>';
            $section->rendered_html = $html;            
        }

        $html = view('plantillas.secciones.partials.email_sections', ['sections' => $sections])->render();
        return response()->json([
            'status' => 'success',
            'html' => $html
        ]);
    }


    public function renderBlock($properties,$typeblock,$col=1,$rowproperties=[],$editor=false,$colwidth=0,$tabs=0){		
        if(!isset($properties)) $properties=[];
        if(!isset($properties["format"])) $properties["format"]=[];

        if($typeblock=="Title"){
            if(!isset($properties["format"]["color"])) $properties["format"]["color"]="#53565A";
            if(!isset($properties["format"]["fontsize"])) $properties["format"]["fontsize"]="22";
            if(!isset($properties["format"]["lineheight"])) $properties["format"]["lineheight"]="28";
            if(!isset($properties["format"]["linkcolor"])) $properties["format"]["linkcolor"]="#007398";
            if(!isset($properties["format"]["fontfamily"]) || $properties["format"]["fontfamily"]=='') $properties["format"]["fontfamily"]="Arial";
            }
        if($typeblock=="Paragraph" ){
            if(!isset($properties["format"]["color"])) $properties["format"]["color"]="#53565A";
            if(!isset($properties["format"]["fontsize"])) $properties["format"]["fontsize"]="15";
            if(!isset($properties["format"]["lineheight"])) $properties["format"]["lineheight"]="19";
            if(!isset($properties["format"]["fontfamily"]) || $properties["format"]["fontfamily"]=='') $properties["format"]["fontfamily"]="Arial";
        }
        if($typeblock=="Button" ){
            if(!isset($properties["format"]["color"]) || $properties["format"]["color"]=='') $properties["format"]["color"]="#FFF";
            if(!isset($properties["format"]["fontsize"]) || $properties["format"]["fontsize"]=='') $properties["format"]["fontsize"]="22";
            if(!isset($properties["format"]["lineheight"]) || $properties["format"]["lineheight"]=='') $properties["format"]["lineheight"]="28";
            if(!isset($properties["format"]["fontfamily"]) || $properties["format"]["fontfamily"]=='') $properties["format"]["fontfamily"]="Arial";
            if(!isset($properties["format"]["buttonborderradius"])) $properties["format"]["buttonborderradius"]="0";
            if(!isset($properties["format"]["buttonborderwidth"])) $properties["format"]["buttonborderwidth"]="0";
            if(!isset($properties["format"]["width"])) $properties["format"]["width"]="100";
            if(!isset($properties["format"]["float"])) $properties["format"]["float"]="";
            if(!isset($properties["format"]["buttonbordercolor"])) $properties["format"]["buttonbordercolor"]="#FFFFFF";
        }

        if($typeblock=="Divider" ){
            if(!isset($properties["format"]["dividercolor"]) || $properties["format"]["dividercolor"]=='') $properties["format"]["dividercolor"]="#DDDDDD";
            if(!isset($properties["format"]["dividerbordertype"]) || $properties["format"]["dividerbordertype"]=='') $properties["format"]["dividerbordertype"]="solid";
            if(!isset($properties["format"]["dividerborderwidth"]) || $properties["format"]["dividerborderwidth"]=='') $properties["format"]["dividerborderwidth"]="1";    
        }

        if($typeblock=="List" ){
            if(!isset($properties["items"] )) $properties["items"]=array(0=>"list item 1",1=>"list item 2",3=>"list item 3");
            if(!isset($properties["format"]["height"])) $properties["format"]["height"]="auto";
        }
        if(!isset($properties["format"]["paddingtop"])) $properties["format"]["paddingtop"]="0";
        if(!isset($properties["format"]["paddingbottom"])) $properties["format"]["paddingbottom"]="0";
        if(!isset($properties["format"]["paddingleft"])) $properties["format"]["paddingleft"]="0";
        if(!isset($properties["format"]["paddingright"])) $properties["format"]["paddingright"]="0";

        if(!isset($properties["format"]["buttonpaddingtop"])) $properties["format"]["buttonpaddingtop"]="10";
        if(!isset($properties["format"]["buttonpaddingbottom"])) $properties["format"]["buttonpaddingbottom"]="10";
        if(!isset($properties["format"]["buttonpaddingleft"])) $properties["format"]["buttonpaddingleft"]="10";
        if(!isset($properties["format"]["buttonpaddingright"])) $properties["format"]["buttonpaddingright"]="10";


        if(!isset($properties["format"]["verticalalign"])) $properties["format"]["verticalalign"]="Top";
        if(!isset($properties["format"]["horizantalalign"])) $properties["format"]["horizantalalign"]="left";
        $properties["format"]["horizantalalign"]=strtolower($properties["format"]["horizantalalign"]);
        $properties["format"]["verticalalign"]=strtolower($properties["format"]["verticalalign"]);        

        if(!isset($properties["format"]["html"])) $properties["format"]["html"]="";        

        switch ($typeblock) {
            case 'Title':return $this->renderTitle($properties,$col,$rowproperties,$editor,$colwidth,$tabs);break;		
            case 'Paragraph':return $this->renderParagraph($properties,$col,$rowproperties,$editor,$colwidth,$tabs);break;
            case 'Divider':return $this->renderDivider($properties,$col,$rowproperties,$editor,$colwidth,$tabs);break;			
            case 'Image':return $this->renderImage($properties,$col,$rowproperties,$editor,$colwidth,$tabs);break;	
            case 'Button':return $this->renderButton($properties,$col,$rowproperties,$editor,$colwidth,$tabs);break;
            case 'List':return $this->renderList($properties,$rowproperties,$colwidth,$col,$editor,$tabs);break;
            case 'Header':return $this->renderHeader($properties);break;		
            case 'Footer':return $this->renderFooter($properties);break;		
            case 'Html':return $this->renderHtml($properties);break;		
            default:return $properties["html"];break;
    	}

    }


    public function renderTitle($properties,$col=1,$rowproperties=[],$editor=false,$colwidth,$numtabs=0){
        if($properties["format"]["fontfamily"]=="Georgia"){
            $properties["format"]["fontfamily"]="Georgia, serif;";
        }else{
            $properties["format"]["fontfamily"]="Arial, Helvetica, sans-serif;";
        }
        $tabs=''; if($numtabs>0) for ($i=0; $i <$numtabs ; $i++) $tabs.='	';
                                return '
    '.$tabs.'<!-- Block Title -->
    '.$tabs.'<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin:0;padding:0;" >
    '.$tabs.'	<tr>
    '.$tabs.'		<td class="'.(intval($colwidth)>180?'heightmobile':'').'" '.(isset($properties["format"]["height"]) && intval($properties["format"]["height"])>0?' height="'.intval($properties["format"]["height"]).'"':'').' valign="'.$properties["format"]["verticalalign"].'" style="
    '.$tabs.'				text-align:'.$properties["format"]["horizantalalign"].';
    '.$tabs.'				vertical-align:'.$properties["format"]["verticalalign"].';
    '.$tabs.'				padding-top:'.$properties["format"]["paddingtop"].'px;
    '.$tabs.'				padding-bottom:'.$properties["format"]["paddingbottom"].'px;
    '.$tabs.'				padding-left:'.$properties["format"]["paddingleft"].'px;
    '.$tabs.'				padding-right:'.$properties["format"]["paddingright"].'px;
    '.$tabs.'				font-family: '.$properties["format"]["fontfamily"].'
    '.$tabs.'				font-size:'.$properties["format"]["fontsize"].'px;
    '.$tabs.'				line-height:'.$properties["format"]["lineheight"].'px;
    '.$tabs.'				color:'.$properties["format"]["color"].';
    '.($properties["format"]["fontstyle"]=="Bold"?$tabs.'				font-weight: 600;':'').''.(strlen($properties["format"]["backgroundcolor"])>2?$tabs.'				background-color:'.$properties["format"]["backgroundcolor"].';':'').
    '"'.(isset($properties["format"]["clases"]) && strlen($properties["format"]["clases"])>0?'
    '.$tabs.'				 class="'.$properties["format"]["clases"].'"' :"").'>'.

    (strlen($properties["link"])>0?'
    '.$tabs.'			<a href="'.($editor?'#':$properties["link"]).'" style="
    '.$tabs.'							color:'.$properties["format"]["linkcolor"].';" target="_blank">':'').'
    '.$tabs.'			'.(isset($properties["text"]) && strlen($properties["text"])>0?strip_tags(trim($properties["text"]),'<br><strong><b><a><i><u><strike><sup>'):'Lorem ipsum dolor sit amet').''.(strlen($properties["link"])>0?'</a>':'').'
    '.$tabs.'		</td>
    '.$tabs.'	</tr>
    '.$tabs.'</table>
    '.$tabs.'<!-- End Block Title -->

    ';
    }


    public function renderDivider($properties,$col=1,$rowproperties=[],$editor=false,$colwidth,$numtabs=0){	
        $tabs=''; if($numtabs>0) for ($i=0; $i <$numtabs ; $i++) $tabs.='	';
                                return '
    '.$tabs.'<!-- Block Divider -->

    '.$tabs.'				<table role="presentation" align="center" cellpadding="0" cellspacing="0" class="full-width" width="100%" >
    '.$tabs.'					<tbody>
    '.$tabs.'						<tr>
    '.$tabs.'							<td align="center" style="padding-top: 0px; border-bottom: '.$properties["format"]["dividerborderwidth"].'px '.$properties["format"]["dividerbordertype"].' '.$properties["format"]["dividercolor"].'; padding-bottom: 0px; line-height: 10px; font-size: 10px">&nbsp;</td>
    '.$tabs.'						</tr>					
    '.$tabs.'						<tr><td height="10" style="font-size: 10px; line-height: 10px; height: 10px">&nbsp;</td></tr>
    '.$tabs.'					</tbody>
    '.$tabs.'				</table>


    '.$tabs.'<!-- End Block Divider -->

    ';
    }

    
    public function renderParagraph($properties,$col=1,$rowproperties=[],$editor=false,$colwidth,$numtabs=0){
        $paragraphText=(isset($properties["text"]) && strlen($properties["text"])>0? strip_tags(trim($properties["text"]),'<br><strong><b><a><i><u><strike><sup><span>'):'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin cursus urna velit, vel posuere justo blandit quis. Aliquam eget pulvinar risus. Duis nisl augue, gravida id mi id, varius cursus mi. Phasellus varius mauris congue, eleifend sapien a, fringilla justo. Pellentesque accumsan volutpat purus, nec tincidunt nisi. Aliquam condium diam orci, a aliquet tortor euismod eget. In pulvinar vestibulum turpis. <a href="">Quisque scelerisque</a> id tellus a iaculis. Vestibulum est felis, rutrum a massa vitae, tristique posuere tellus');

        $color=$properties["format"]["linkcolor"];
        $paragraphText = preg_replace_callback(
        '/<a\s+([^>]*href=["\'].*?["\'][^>]*)>/i',
        function ($coincidencia) use ($color) {
            $atributos = $coincidencia[1];
            // Verificamos si ya tiene el atributo 'style'
            if (strpos($atributos, 'style=') === false) {            
                $nuevo_a = '<a ' . $atributos . ' style="color:'.$color.';text-decoration:none;">';
            } else {            
                $nuevo_a = preg_replace('/style=["\']([^"\']*)["\']/', 'style="$1 text-decoration:none;"', '<a ' . $atributos . '>');
            }

            return $nuevo_a;
        },
        $paragraphText
        );
        /*if($properties["format"]["fontfamily"]=="Georgia"){
            $properties["format"]["fontfamily"]="Georgia, serif;";
        }else{
            $properties["format"]["fontfamily"]="Arial, Helvetica, sans-serif;";
        }*/
            $tabs=''; if($numtabs>0) for ($i=0; $i <$numtabs ; $i++) $tabs.='	';
        return '
        '.$tabs.'<!-- Block P -->
        '.$tabs.'<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin:0;padding:0;" >
        '.$tabs.'	<tr>
        '.$tabs.'		<td class="'.(intval($colwidth)>180?'heightmobile':'').'" '.(isset($properties["format"]["height"]) && intval($properties["format"]["height"])>0?' height="'.intval($properties["format"]["height"]).'"':'').' valign="'.$properties["format"]["verticalalign"].'" style="
        '.$tabs.'				text-align:'.$properties["format"]["horizantalalign"].';
        '.$tabs.'				vertical-align:'.$properties["format"]["verticalalign"].';
        '.$tabs.'				padding-top:'.$properties["format"]["paddingtop"].'px;
        '.$tabs.'				padding-bottom:'.$properties["format"]["paddingbottom"].'px;
        '.$tabs.'				padding-left:'.$properties["format"]["paddingleft"].'px;
        '.$tabs.'				padding-right:'.$properties["format"]["paddingright"].'px;
        '.$tabs.'				font-family: '.$properties["format"]["fontfamily"].'
        '.$tabs.'				font-size:'.$properties["format"]["fontsize"].'px;
        '.$tabs.'				line-height:'.$properties["format"]["lineheight"].'px;
        '.$tabs.'				color:'.$properties["format"]["color"].';'.($properties["format"]["fontstyle"]=="Bold"?'
        '.$tabs.'				font-weight: 600;':'').''.(strlen($properties["format"]["backgroundcolor"])>2?'
        '.$tabs.'				background-color:'.$properties["format"]["backgroundcolor"].';':'').'" >
        '.$tabs.'			'.$paragraphText.'
        '.$tabs.'		</td>
        '.$tabs.'	</tr>
        '.$tabs.'</table>
        '.$tabs.'<!-- End Block P -->
        ';
                                                                        
    }

    public function renderImage($properties,$col=1,$rowproperties=[],$editor=false,$colwidth,$numtabs=0){

        $tabs=''; if($numtabs>0) for ($i=0; $i <$numtabs ; $i++) $tabs.='	';
            $imgwidth=intval($colwidth)-intval($properties["format"]["paddingleft"])-intval($properties["format"]["paddingright"])-2*intval($properties["format"]["imageborderwidth"]);		
    return '
    '.$tabs.'<!-- Block Image -->
    '.$tabs.'<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin:0;padding:0;" >
    '.$tabs.'	<tr>
    '.$tabs.'		<td class="'.(intval($colwidth)>180?'heightmobile':'').'" '.(isset($properties["format"]["height"]) && intval($properties["format"]["height"])>0?' height="'.intval($properties["format"]["height"]).'"':'').' valign="'.$properties["format"]["verticalalign"].'" style="
    '.$tabs.'				text-align:'.$properties["format"]["horizantalalign"].';
    '.$tabs.'				vertical-align:'.$properties["format"]["verticalalign"].';
    '.$tabs.'				padding-top:'.$properties["format"]["paddingtop"].'px;
    '.$tabs.'				padding-bottom:'.$properties["format"]["paddingbottom"].'px;
    '.$tabs.'				padding-left:'.$properties["format"]["paddingleft"].'px;
    '.$tabs.'				padding-right:'.$properties["format"]["paddingright"].'px;'.


    (strlen($properties["format"]["backgroundcolor"])>2?'background-color:'.$properties["format"]["backgroundcolor"].';':'').' " >'.
    (strlen($properties["link"])>0?'
    '.$tabs.'			<a href="'.($editor?'#':$properties["link"]).'" target="_blank" alt="'.(strlen($properties["alt"])>0?$properties["alt"]:'').' "> ':'').'
    '.$tabs.'				<img style="'.(intval($properties["format"]["imageborderwidth"])>0?'border:'.intval($properties["format"]["imageborderwidth"]).'px '.$properties["format"]["imageborderstyle"].' '.$properties["format"]["imagebordercolor"].';' : '').' '.(intval($properties["format"]["imageborderradius"])>0?'border-radius: '.intval($properties["format"]["imageborderradius"]).'px ;':'').'" alt="'.(strlen($properties["alt"])>0?$properties["alt"]:'').'" title="'.(strlen($properties["title"])>0?$properties["title"]:'').'" width="'.$imgwidth.'" src="'.(strlen($properties["imageurl"])>0?$properties["imageurl"]:'https://marketingtool.s3-eu-west-1.amazonaws.com/ecb/templates2021/book200.jpg').'" class="'.(strlen($properties["responsive"]["widthimage"])>0 ? $properties["responsive"]["widthimage"] : "").'">
    '.$tabs.'			'.(strlen($properties["link"])>0?'</a>':'').'
    '.$tabs.'		</td>
    '.$tabs.'	</tr>
    '.$tabs.'</table>
    '.$tabs.'<!-- End Block Image -->
    ';
    }


    public function renderButton($properties,$col=1,$rowproperties=[],$editor=false,$colwidth,$numtabs=0){
        $arcsize=0;
        if(intval($properties["format"]["buttonborderradius"])==0) $arcsize=0;
        if(intval($properties["format"]["buttonborderradius"])>0 && intval($properties["format"]["buttonborderradius"])<8) $arcsize=15;
        if(intval($properties["format"]["buttonborderradius"])>8 && intval($properties["format"]["buttonborderradius"])<20) $arcsize=30;
        if(intval($properties["format"]["buttonborderradius"])>=20) $arcsize=50;
        
        $tabs=''; if($numtabs>0) for ($i=0; $i <$numtabs ; $i++) $tabs.='	';

        $btnwidth=intval($colwidth)-intval($properties["format"]["paddingleft"])-intval($properties["format"]["paddingright"])-2*intval($properties["format"]["buttonborderwidth"]);
        if(intval($properties["format"]["width"])>0) $btnwidth=$btnwidth*intval($properties["format"]["width"])/100;
        

        $heightMSO=$properties["format"]["lineheight"];
        $heightMSO+=$properties["format"]["buttonpaddingtop"]+$properties["format"]["buttonpaddingbottom"]+$properties["format"]["paddingtop"]+$properties["format"]["paddingbottom"];
        $btnheightMSO=$heightMSO-$properties["format"]["paddingtop"]-$properties["format"]["paddingbottom"];
        if(isset($properties["format"]["height"]) && intval($properties["format"]["height"])>0) $btnheightMSO=intval($properties["format"]["height"]);
        if(intval($properties["format"]["lines"])>0){
            $height=$properties["format"]["lineheight"]*$properties["format"]["lines"];
            $height+=$properties["format"]["buttonpaddingtop"]+$properties["format"]["buttonpaddingbottom"]+$properties["format"]["paddingtop"]+$properties["format"]["paddingbottom"];
            $heightbottom=$height-$properties["format"]["paddingtop"]-$properties["format"]["paddingbottom"];
            $btnheightMSO=$heightbottom;
        }

    return '
    '.$tabs.'<!-- Block Button -->
    '.$tabs.'<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin:0;padding:0;" >
    '.$tabs.'	<tr>
    '.$tabs.'		<td style="
    '.$tabs.'				padding-top:'.$properties["format"]["paddingtop"].'px;
    '.$tabs.'				padding-bottom:'.$properties["format"]["paddingbottom"].'px;
    '.$tabs.'				padding-left:'.$properties["format"]["paddingleft"].'px;
    '.$tabs.'				padding-right:'.$properties["format"]["paddingright"].'px;" >
    '.$tabs.'			<table role="presentation" width="100%" align="'.(strlen($properties["format"]["float"])>0? ($properties["format"]["float"]=='none'?'center': $properties["format"]["float"]) :'center').'"  cellpadding="0" cellspacing="0" class="m_botonfull" style="margin:0 auto; width:'.$properties["format"]["width"].'%; float: '.$properties["format"]["float"].';">
    '.$tabs.'				<tr>
    '.$tabs.'					<td class="'.(intval($colwidth)>180?'heightmobile':'').'" '.(isset($properties["format"]["height"]) && intval($properties["format"]["height"])>0?' height="'.intval($properties["format"]["height"]).'"':'').' valign="'.$properties["format"]["verticalalign"].'"  style="vertical-align:'.$properties["format"]["verticalalign"].';">
    '.$tabs.'						<table role="presentation" width="100%"  cellpadding="0" cellspacing="0" class="" style="margin:0 auto; float:none;">
    '.$tabs.'							<tr>
    '.$tabs.'								<td align="center" class="botonfull">
    '.$tabs.'									<div>
    '.$tabs.'									<!--[if mso]>
    '.$tabs.'										<v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" 
    '.$tabs.'											href="'.($editor?'https://www.elsevier.com':$properties["link"]).'"													
    '.$tabs.'											style="
    '.$tabs.'													height:'.$btnheightMSO.'px;
    '.$tabs.'													v-text-anchor:middle;
    '.$tabs.'													width:'.$btnwidth.'px;" 
    '.$tabs.'											arcsize="'.$arcsize.'%" 
    '.$tabs.'											strokecolor="'.$properties["format"]["buttonbordercolor"].'" 
    '.$tabs.'											strokeweight="'.intval($properties["format"]["buttonborderwidth"]).'pt"
    '.$tabs.'											stroked="'.(intval($properties["format"]["buttonborderwidth"])>0 ? 'true':'false' ).'"
    '.$tabs.'											'.(strlen($properties["format"]["backgroundcolor"])>2?'fillcolor="'.$properties["format"]["backgroundcolor"].'";':'').'
    '.$tabs.'											>
    '.$tabs.'											<w:anchorlock/>
    '.$tabs.'											<center style="color:'.$properties["format"]["linkcolor"].';
    '.$tabs.'																font-family:Helvetica,Arial,sans-serif;
    '.$tabs.'																font-size:'.$properties["format"]["fontsize"].'px">
    '.$tabs.'														'.(isset($properties["text"]) && strlen($properties["text"])>0?trim($properties["text"]):'CTA Text').'
    '.$tabs.'											</center>
    '.$tabs.'										</v:roundrect>
    '.$tabs.'									<![endif]-->
    '.$tabs.'									<a href="'.($editor?'#':$properties["link"]).'" target="_blank" class="botonfull" '.(isset($heightbottom) && intval($heightbottom)>0?' height="'.$heightbottom.'"':'').' 
    '.$tabs.'											style="
    '.$tabs.'												mso-hide:all;
    '.$tabs.'												text-align:'.(isset($properties["format"]["buttontextalign"]) && $properties["format"]["buttontextalign"]!=""?$properties["format"]["buttontextalign"]:"center").';
    '.$tabs.'												font-family: Arial, Helvetica, sans-serif;
    '.$tabs.'												display:block;
    '.$tabs.'												font-size:'.$properties["format"]["fontsize"].'px;
    '.$tabs.'												line-height:'.$properties["format"]["lineheight"].'px;
    '.$tabs.'												padding-top:'.$properties["format"]["buttonpaddingtop"].'px;
    '.$tabs.'												padding-bottom:'.$properties["format"]["buttonpaddingbottom"].'px;
    '.$tabs.'												padding-left:'.$properties["format"]["buttonpaddingleft"].'px;
    '.$tabs.'												padding-right:'.$properties["format"]["buttonpaddingright"].'px;
    '.$tabs.'												color:'.$properties["format"]["linkcolor"].';
    '.$tabs.'												'.(intval($properties["format"]["buttonborderwidth"])>0? 'border: '.intval($properties["format"]["buttonborderwidth"]).'px '.$properties["format"]["buttonborderstyle"].' '.$properties["format"]["buttonbordercolor"].';' : '').'
    '.$tabs.'												'.(intval($properties["format"]["buttonborderradius"])>0?'border-radius: '.intval($properties["format"]["buttonborderradius"]).'px ;':'').'
    '.$tabs.'												'.(strlen($properties["format"]["backgroundcolor"])>2?'background-color:'.$properties["format"]["backgroundcolor"].';':'').'">
    '.$tabs.'												'.(isset($properties["text"]) && strlen($properties["text"])>0?trim($properties["text"]):'Lorem ipsum dolor sit amet').'												
    '.$tabs.'									</a>
    '.$tabs.'									</div>
    '.$tabs.'								</td>
    '.$tabs.'							</tr>
    '.$tabs.'						</table>
    '.$tabs.'					</td>
    '.$tabs.'				</tr>
    '.$tabs.'			</table>
    '.$tabs.'		</td>
    '.$tabs.'	</tr>
    '.$tabs.'</table>
    '.$tabs.'<!-- Block Button -->
    ';
    }



    public function renderHtml($properties){	
        if(strlen($properties["format"]["html"])>0)
        return '
    <!-- Block HTML -->
    '.$properties["format"]["html"].'
    <!-- End Block HTML -->
    ';
        else 
            return '
    <!-- Block HTML -->
    <table  bgcolor="#ffffff" cellpadding="0" cellspacing="0" width="100%">HTML content</table>
    <!-- End Block HTML -->
    ';
    }

    public function renderHeader($properties){
        if(strlen($properties["format"]["html"])>0)
        return '
            <!-- Block Header -->
            '.$properties["format"]["html"].'
            <!-- End Block Header -->
    ';
        else 
            return '
    <!-- Block Header -->
    <table bgcolor="#ffffff" cellpadding="0" cellspacing="0" width="100%">Header</table>
    <!-- End Block Header -->
    ';
    }

    public function renderFooter($properties){

        //var_dump($properties); die();
        /*
        if(strlen($properties["format"]["html"])>0)
        return '
            <!-- Block Footer -->
            '.$properties["format"]["html"].'
            <!-- End Block Footer -->
        ';
        else 
        return '
            <!-- Block Footer -->
            <table bgcolor="#ffffff" cellpadding="0" cellspacing="0" width="100%">Footer</table>
            <!-- End Block Footer -->
        ';
        */
        return '
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" bgcolor="#ffffff">
                    <tr>
                        <td align="center">
                        <table role="presentation" width="600" cellpadding="0" cellspacing="0" class="full-width" bgcolor="#ffffff" align="center" 
                        style="border-top: '.(isset($properties["format"]["footerborderwidth"]) ? intval($properties["format"]["footerborderwidth"]).'px':'1px').' '.(isset($properties["format"]["footerborderstyle"]) ? $properties["format"]["footerborderstyle"] :'solid').' '.(isset($properties["format"]["footerbordercolor"]) ? $properties["format"]["footerbordercolor"] :'#0A879F').'">
                            <tr>
                            <td style="padding-top: 30px;" class="top20">
                                <table role="presentation" width="560" align="center" cellpadding="0" cellspacing="0" class="width90" style="margin: 0 auto;">
                                <tr>
                                    <td valign="top" align="left" style="font-family: Arial, Helvetica, sans-serif; font-size:9px; color:#53565A;">
                                    <a href="https://meetsite.es/" target="_blank" style="color:#53565A; text-decoration:none; border:none;">
                                        <img src="https://app.meetsite.es/assets/images/logo-black.png" alt="Meetsite" width="100" height="61" border="0" style="width:100px; height:61px;">
                                    </a>
                                    </td>
                                    <td valign="top" align="right" style="font-family: Arial, Helvetica, sans-serif; font-size:12px; color:#53565A; text-align:right;">
                                    '.((isset($properties["nombreacademia"]) && strlen($properties["nombreacademia"])>0 ) ? '<strong>'.$properties["nombreacademia"].'</strong><br>': '').'
                                    '.((isset($properties["direccionacademia"]) && strlen($properties["direccionacademia"])>0 ) ? $properties["direccionacademia"].'<br>': '').'                                    
                                    '.((isset($properties["telefonoacademia"]) && strlen($properties["telefonoacademia"])>0 ) ? 'Tel: <a href="tel:'. str_replace(' ', '', $properties["telefonoacademia"]).'">'.$properties["telefonoacademia"].'</a><br>':'').' 
                                    '.((isset($properties["emailacademia"]) && strlen($properties["emailacademia"])>0 ) ? '<a href="mailto:'.$properties["emailacademia"].'" style="color:#0A879F; text-decoration:none;">'.$properties["emailacademia"].'</a><br>':'').'                                     
                                    </td>
                                </tr>
                                </table>
                            </td>
                            </tr>
                            <tr>
                            <td height="50" style="padding-top:40px; padding-left:10px; padding-right:10px; font-family: Arial, Helvetica, sans-serif; font-size:12px; line-height:17px; color:#53565A; text-align:center;">
                                © '.date('Y').' Meetsite. Todos los derechos reservados.
                            </td>
                            </tr>
                        </table>
                        </td>
                    </tr>
                    </table>';

    }

    function renderList($properties,$rowproperties=[],$colwidth,$col=1,$editor=false,$numtabs=0){
        $tabs=''; if($numtabs>0) for ($i=0; $i <$numtabs ; $i++) $tabs.='	';
    $temphtml='';
    $temphtml.=' 
    '.$tabs.'<!-- Block List -->
    '.$tabs.'<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin:0;padding:0;" >
    '.$tabs.'	<tr>
    '.$tabs.'		<td class="'.(intval($colwidth)>180?'heightmobile':'').'" '.(intval($properties["format"]["height"])>0?' height="'.intval($properties["format"]["height"]).'"':'').' valign="'.$properties["format"]["verticalalign"].'" style="text-align:'.$properties["format"]["horizantalalign"].';
    '.$tabs.'				vertical-align:'.$properties["format"]["verticalalign"].';
    '.$tabs.'				padding-top:'.$properties["format"]["paddingtop"].'px;
    '.$tabs.'				padding-bottom:'.$properties["format"]["paddingbottom"].'px;
    '.$tabs.'				padding-left:'.$properties["format"]["paddingleft"].'px;
    '.$tabs.'				padding-right:'.$properties["format"]["paddingright"].'px;
    '.$tabs.'				font-family: Arial, Helvetica, sans-serif;
    '.$tabs.'				font-size:'.$properties["format"]["fontsize"].'px;
    '.$tabs.'				line-height:'.$properties["format"]["lineheight"].'px;color:'.$properties["format"]["color"].';'.
    (strlen($properties["format"]["backgroundcolor"])>2?$tabs.'				background-color:'.$properties["format"]["backgroundcolor"].';':'').
    ($properties["format"]["fontstyle"]=="Bold"?$tabs.'				font-weight:600;':'').'" >';
        
        if($properties["items"] && is_array($properties["items"])){
            $temphtml.='
    '.$tabs.'			<ul>';
            foreach ($properties["items"] as $key => $item) {
                $paragraphText=(isset($item) && strlen($item)>0? strip_tags(trim($item),'<br><strong><b><a><i><u><strike><sup><span>'):'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin cursus urna velit, vel posuere justo blandit quis. Aliquam eget pulvinar risus. Duis nisl augue, gravida id mi id, varius cursus mi. Phasellus varius mauris congue, eleifend sapien a, fringilla justo. Pellentesque accumsan volutpat purus, nec tincidunt nisi. Aliquam condium diam orci, a aliquet tortor euismod eget. In pulvinar vestibulum turpis. <a href="">Quisque scelerisque</a> id tellus a iaculis. Vestibulum est felis, rutrum a massa vitae, tristique posuere tellus');
                $color=$properties["format"]["linkcolor"];
                $paragraphText = preg_replace_callback(
                '/<a\s+([^>]*href=["\'].*?["\'][^>]*)>/i',
                function ($coincidencia) use ($color) {
                    $atributos = $coincidencia[1];
                    // Verificamos si ya tiene el atributo 'style'
                    if (strpos($atributos, 'style=') === false) {            
                        $nuevo_a = '<a ' . $atributos . ' style="color:'.$color.';text-decoration:none;">';
                    } else {            
                        $nuevo_a = preg_replace('/style=["\']([^"\']*)["\']/', 'style="$1 text-decoration:none;"', '<a ' . $atributos . '>');
                    }

                    return $nuevo_a;
                },
                $paragraphText
                );
                $temphtml.='
    '.$tabs.'				<li style="
    '.$tabs.'						padding-bottom:'.$properties["format"]["itempaddingtop"].'px; 
    '.$tabs.'						padding-top:'.$properties["format"]["itempaddingtop"].'px; 
    '.$tabs.'						padding-right:'.$properties["format"]["itempaddingright"].'px; 
    '.$tabs.'						padding-left:'.$properties["format"]["itempaddingleft"].'px;">
    '.$tabs.'					'.$paragraphText.'
    '.$tabs.'				</li>';
            }
            $temphtml.='
    '.$tabs.'			</ul>';
        }
    $temphtml.='
    '.$tabs.'		</td>
    '.$tabs.'	</tr>
    '.$tabs.'</table>
    '.$tabs.'<!-- End Block List -->
    ';
    return $temphtml;

    }








    public function renderRow($cols,$properties){
                        
            $rowhtml='';
            if(!isset($properties["format"]["width"])) $properties["format"]["width"]=600;
            if(!isset($properties["format"]["widthinner"])) $properties["format"]["widthinner"]=580;            

            if(!isset($properties["format"]["backgroundcolor"])) $properties["format"]["backgroundcolor"]="#ffffff";

            if(!isset($properties["format"]["verticalalign"])) $properties["format"]["verticalalign"]="Top";
            if(!isset($properties["format"]["horizantalalign"])) $properties["format"]["horizantalalign"]="Left";
            $properties["format"]["verticalalign"]=strtolower($properties["format"]["verticalalign"]);
            $properties["format"]["horizantalalign"]=strtolower($properties["format"]["horizantalalign"]);
            if(!isset($properties["format"]["paddingtop"])) $properties["format"]["paddingtop"]="10";
            if(!isset($properties["format"]["paddingbottom"]) || $properties["format"]["paddingbottom"]=='') $properties["format"]["paddingbottom"]="10";
            if(!isset($properties["format"]["paddingleft"])) $properties["format"]["paddingleft"]="10";
            if(!isset($properties["format"]["paddingright"])) $properties["format"]["paddingright"]="10";
            $cols_width=[];

            /*if(isset($properties["format"]["sectionbackgroundcolor"])){
                echo "Existe elemento: ".$properties["format"]["sectionbackgroundcolor"]."<br>";
            }*/



            $rowhtml.='
            <!-- Row  Cols: '.$cols.'-->
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" bgcolor="'. (isset($properties["format"]["sectionbackgroundcolor"]) ?$properties["format"]["sectionbackgroundcolor"]:'').'">
                <tbody>
                    <tr>
                        <td align="center" >
                            <table role="presentation" width="'.$properties["format"]["width"].'" cellpadding="0" cellspacing="0"  align="center" class="full-width" style="
                                                    min-width:'.$properties["format"]["width"].'px;">
                                <tbody>
                                    <tr>
                                        <td align="'.strtolower($properties["format"]["horizantalalign"]).'" 
                                                valign="'.strtolower($properties["format"]["verticalalign"]).'" 
                                                bgcolor="'. $properties["format"]["backgroundcolor"].'" 
                                            style="
                                                text-align:'.$properties["format"]["horizantalalign"].';
                                                vertical-align:'.$properties["format"]["verticalalign"].';
                                                padding-top:'.$properties["format"]["paddingtop"].'px;
                                                padding-bottom:'.$properties["format"]["paddingbottom"].'px;
                                                padding-left:'.$properties["format"]["paddingleft"].'px;
                                                padding-right:'.$properties["format"]["paddingright"].'px;">
                                                    ';
                if($cols==1){
                    $cols_width[1]=$properties["format"]["widthinner"];
                                $rowhtml.='
                                            <table 
                                                role="presentation"
                                                width="'.$properties["format"]["widthinner"].'" cellpadding="0" cellspacing="0" 
                                                class="'.(isset($properties["responsive"]["width"]) && strlen($properties["responsive"]["width"])>0 ? $properties["responsive"]["width"] : "m_width90").'" align="center">
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <!-- Col -->
            @@col1_blocks@@
                                                            <!-- End Col -->
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>';
                }elseif($cols==2){

                    switch ($properties["format"]["colformat"]) {
                        case '60%-40%':
                        $cols_width[1]=intval(intval($properties["format"]["widthinner"]-8)*0.6,); //310;
                        $cols_width[2]=intval(intval($properties["format"]["widthinner"]-8)*0.4,); //240;
                            break;
                        case '40%-60%':
                        $cols_width[1]=intval(intval($properties["format"]["widthinner"]-8)*0.4,); //240;
                        $cols_width[2]=intval(intval($properties["format"]["widthinner"]-8)*0.6,); //310;
                            break;
                            case '30%-70%':
                        $cols_width[1]=intval(intval($properties["format"]["widthinner"]-8)*0.3,); //310;
                        $cols_width[2]=intval(intval($properties["format"]["widthinner"]-8)*0.7,); //240;
                            break;
                            case '70%-30%':
                        $cols_width[1]=intval(intval($properties["format"]["widthinner"]-8)*0.7,); //310;
                        $cols_width[2]=intval(intval($properties["format"]["widthinner"]-8)*0.3,); //240;      	
                            break;
                            case '50%-50%':          
                        default:
                        $cols_width[1]=intval(intval($properties["format"]["widthinner"]-6)*0.5,); //275;
                        $cols_width[2]=intval(intval($properties["format"]["widthinner"]-6)*0.5,); //275;

                        break;
                    }
                    $rowhtml.='
                                            <table role="presentation" width="'.$properties["format"]["widthinner"].'" cellpadding="0" cellspacing="0" class="m_width90" align="center">
                                                <tbody>
                                                    <tr>
                                                        <td align="center">
                                                            <table role="presentation" width="'.$cols_width[1].'" cellpadding="0" cellspacing="0" class="full-width" align="left" style="float: left;">
                                                                <tbody>
                                                                    <tr>
                                                                        <td>
                                                                            <!-- Col -->
            @@col1_blocks@@
                                                                            <!-- End Col -->
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            <table role="presentation" width="'.$cols_width[2].'" cellpadding="0" cellspacing="0" class="full-width" align="right" style="float: right;">
                                                                <tbody>
                                                                    <tr>
                                                                        <td>
                                                                            <!-- Col -->
            @@col2_blocks@@
                                                                            <!-- End Col -->
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                    ';
                }elseif($cols==3){

                    switch ($properties["format"]["colformat"]) {
                        case '50%-25%-25%':
                        $cols_width[1]=intval(intval($properties["format"]["widthinner"]-10)*0.5,); //275;
                        $cols_width[2]=intval(intval($properties["format"]["widthinner"]-8)*0.25,); //135;
                        $cols_width[3]=intval(intval($properties["format"]["widthinner"]-8)*0.25,); //135;
                    $rowhtml.='
                                            <table role="presentation" width="'.$properties["format"]["widthinner"].'" cellpadding="0" cellspacing="0" class="m_width90" align="center">
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <table role="presentation" width="'.$cols_width[1].'" cellpadding="0" cellspacing="0" class="full-width" align="left" style="float: left;">
                                                                <tbody>
                                                                    <tr>
                                                                        <td>
                                                                                            <!-- Col -->
            @@col1_blocks@@
                                                                                            <!-- End Col -->
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            <table role="presentation" width="'.$cols_width[1].'" cellpadding="0" cellspacing="0" class="full-width" align="left" style="float: left;">
                                                                <tbody>
                                                                    <tr>
                                                                        <td align="center" valign="top">
                                                                            <table role="presentation" width="'.$cols_width[2].'" cellpadding="0" cellspacing="0" class="full-width" align="left">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td align="'.strtolower($properties["format"]["horizantalalign"]).'" valign="'.strtolower($properties["format"]["verticalalign"]).'" style="text-align:'.$properties["format"]["horizantalalign"].';vertical-align:'.$properties["format"]["verticalalign"].';">
                                                                                            <!-- Col -->
            @@col2_blocks@@
                                                                                            <!-- End Col -->
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </td>
                                                                        <td align="center" valign="top">
                                                                            <table role="presentation" width="'.$cols_width[3].'" cellpadding="0" cellspacing="0" class="full-width" align="left">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <!-- Col -->
            @@col3_blocks@@
                                                                                            <!-- End Col -->
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>';
                        break;

                    case '25%-25%-50%':
                    $cols_width[1]=intval(intval($properties["format"]["widthinner"]-8)*0.25,); //135;
                    $cols_width[2]=intval(intval($properties["format"]["widthinner"]-8)*0.25,); //135;
                    $cols_width[3]=intval(intval($properties["format"]["widthinner"]-10)*0.5,); //275;
                    $rowhtml.='
                                            <table role="presentation" width="'.$properties["format"]["widthinner"].'" cellpadding="0" cellspacing="0" class="m_width90" align="center">
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <table role="presentation" width="'.$cols_width[3].'" cellpadding="0" cellspacing="0" class="full-width" align="left" style="float: left;">
                                                                <tbody>
                                                                    <tr>
                                                                        <td align="center" valign="top">
                                                                            <table role="presentation" width="'.$cols_width[1].'" cellpadding="0" cellspacing="0" class="full-width" align="left">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <!-- Col -->
            @@col1_blocks@@
                                                                                            <!-- End Col -->
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </td>
                                                                        <td align="center" valign="top">
                                                                            <table role="presentation" width="'.$cols_width[2].'" cellpadding="0" cellspacing="0" class="full-width" align="left">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <!-- Col -->
            @@col2_blocks@@
                                                                                            <!-- End Col -->
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            <table role="presentation" width="'.$cols_width[3].'" cellpadding="0" cellspacing="0" class="full-width" align="left" style="float: left;">
                                                                <tbody>
                                                                    <tr>
                                                                        <td>
                                                                            <!-- Col -->
            @@col3_blocks@@
                                                                            <!-- End Col -->
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>';
                        break;
                    case '25%-50%-25%':
                    case '33%':
                    default:
                    $cols_width[1]=intval(intval($properties["format"]["widthinner"]-8)*0.33333,); //180;
                    $cols_width[2]=intval(intval($properties["format"]["widthinner"]-8)*0.33333,); //180;
                    $cols_width[3]=intval(intval($properties["format"]["widthinner"]-8)*0.33333,); //180;
                    $rowhtml.='
                                            <table role="presentation" width="'.$properties["format"]["widthinner"].'" cellpadding="0" cellspacing="0" class="m_width90"  align="center">
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <table role="presentation" width="'.$cols_width[1].'" cellpadding="0" cellspacing="0" class="full-width" align="left" style="float: left;">
                                                                <tbody>
                                                                    <tr>
                                                                        <td>
                                                                            <!-- Col -->
            @@col1_blocks@@
                                                                            <!-- End Col -->
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            <table role="presentation" width="'.$cols_width[2].'" cellpadding="0" cellspacing="0" class="full-width" align="left" style="float: left;">
                                                                <tbody>
                                                                    <tr>
                                                                        <td>
                                                                            <!-- Col -->
            @@col2_blocks@@
                                                                            <!-- End Col -->
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            <table role="presentation" width="'.$cols_width[3].'" cellpadding="0" cellspacing="0" class="full-width" align="left" style="float: left;">
                                                                <tbody>
                                                                    <tr>
                                                                        <td>
                                                                            <!-- Col -->
            @@col3_blocks@@
                                                                            <!-- End Col -->
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>';
                        break;

                    }


                }elseif($cols==4){
                    

                    switch ($properties["format"]["colformat"]) {

                        case "25/75%-25/75%":
                            $cols_width[1]=intval( intval(intval($properties["format"]["widthinner"])-14)*1/4/2,); //135;
                            $cols_width[2]=intval( intval(intval($properties["format"]["widthinner"])-20)*3/4/2,); //135;
                            $cols_width[3]=intval( intval(intval($properties["format"]["widthinner"])-14)*1/4/2,); //135;
                            $cols_width[4]=intval( intval(intval($properties["format"]["widthinner"])-20)*3/4/2,); //135;
                
                            $cols_width[0]=intval(intval(intval($properties["format"]["widthinner"])-8)*0.50,); //135;

                            $rowhtml.='
                                            <table role="presentation" width="'.$properties["format"]["widthinner"].'" cellpadding="0" cellspacing="0" class="m_width90"  align="center">
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <table role="presentation" width="'.$cols_width[0].'" cellpadding="0" cellspacing="0" class="full-width" align="left" style="float: left;">
                                                                <tbody>
                                                                    <tr>
                                                                        <td align="center" valign="top" width="25%">
                                                                            <table role="presentation" width="'.$cols_width[1].'" cellpadding="0" cellspacing="0" class="full-width" align="left">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <!-- Col -->
            @@col1_blocks@@
                                                                                            <!-- End Col -->
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </td>
                                                                        <td align="center" valign="top" width="75%">
                                                                            <table role="presentation" width="'.$cols_width[2].'" cellpadding="0" cellspacing="0" class="full-width" align="left">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <!-- Col -->
            @@col2_blocks@@
                                                                                            <!-- End Col -->
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            <table role="presentation" width="'.$cols_width[0].'" cellpadding="0" cellspacing="0" class="full-width" align="left" style="float: left;">
                                                                <tbody>
                                                                    <tr>
                                                                        <td align="center" valign="top" width="25%">
                                                                            <table role="presentation" width="'.$cols_width[3].'" cellpadding="0" cellspacing="0" class="full-width" align="left">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <!-- Col -->
            @@col3_blocks@@
                                                                                            <!-- End Col -->
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </td>
                                                                        <td align="center" valign="top" width="75%">
                                                                            <table role="presentation" width="'.$cols_width[4].'" cellpadding="0" cellspacing="0" class="full-width" align="left">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <!-- Col -->
            @@col4_blocks@@
                                                                                            <!-- End Col -->
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>';

                            break;

                        default:
                            $cols_width[1]=intval( intval(intval($properties["format"]["widthinner"])-28)*0.25,); //135;
                            $cols_width[2]=intval( intval(intval($properties["format"]["widthinner"])-28)*0.25,); //135;
                            $cols_width[3]=intval( intval(intval($properties["format"]["widthinner"])-28)*0.25,); //135;
                            $cols_width[4]=intval( intval(intval($properties["format"]["widthinner"])-28)*0.25,); //135;
                
                            $cols_width[0]=intval(intval(intval($properties["format"]["widthinner"])-8)*0.50,); //135;
                            $rowhtml.='
                                            <table role="presentation" width="'.$properties["format"]["widthinner"].'" cellpadding="0" cellspacing="0" class="m_width90"  align="center">
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <table role="presentation" width="'.$cols_width[0].'" cellpadding="0" cellspacing="0" class="full-width" align="left" style="float: left;">
                                                                <tbody>
                                                                    <tr>
                                                                        <td align="center" valign="top" width="50%">
                                                                            <table role="presentation" width="'.$cols_width[1].'" cellpadding="0" cellspacing="0" class="full-width" align="left">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <!-- Col -->
            @@col1_blocks@@
                                                                                            <!-- End Col -->
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </td>
                                                                        <td align="center" valign="top" width="50%">
                                                                            <table role="presentation" width="'.$cols_width[1].'" cellpadding="0" cellspacing="0" class="full-width" align="left">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <!-- Col -->
            @@col2_blocks@@
                                                                                            <!-- End Col -->
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            <table role="presentation" width="'.$cols_width[0].'" cellpadding="0" cellspacing="0" class="full-width" align="left" style="float: left;">
                                                                <tbody>
                                                                    <tr>
                                                                        <td align="center" valign="top" width="50%">
                                                                            <table role="presentation" width="'.$cols_width[1].'" cellpadding="0" cellspacing="0" class="full-width" align="left">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <!-- Col -->
            @@col3_blocks@@
                                                                                            <!-- End Col -->
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </td>
                                                                        <td align="center" valign="top" width="50%">
                                                                            <table role="presentation" width="'.$cols_width[1].'" cellpadding="0" cellspacing="0" class="full-width" align="left">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <!-- Col -->
            @@col4_blocks@@
                                                                                            <!-- End Col -->
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>';
                            break;

                    }
                    
                    
                }
                    $rowhtml.='
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
            <!-- End Row -->
            ';      		        
        
    
    return ['html'=>$rowhtml,'width'=>$cols_width];   

    }



}