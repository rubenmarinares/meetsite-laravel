<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

use Illuminate\Support\ViewErrorBag;
use App\Traits\TraitFormPlantilla;



/**
 * Class PlantillaRequest
 *
 * @method array all($keys = null)        Obtener todos los datos del request
 * @method mixed input($key = null, $default = null) Obtener un campo específico
 * @method bool isMethod(string $method)  Verificar el método HTTP (GET, POST, PUT...)
 * @method mixed route($param = null, $default = null) Obtener parámetro de la ruta
 *
 * @property-read array $errors           Acceso al bag de errores
 */
 

class PlantillaRequest extends FormRequest

{
    use TraitFormPlantilla;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
                                  

        return [
            'nombre' => ['required','string','max:255'],
            'plantilla' => ['required','integer'],
            'userid' => ['required','integer'],
            'academiaid' => ['required','integer']            
        ];
    }


    public function messages():array{
        return [
            'nombre.required'=>'El campo nombre es obligatorio',            
            'nombre.string'=>'El campo nombre debe ser un texto',
            'nombre.max'=>'El campo nombre no debe superar los :max caracteres',            
        ];
    }



    public function failedValidation(Validator $validator)
    {        

        $viewErrors = new ViewErrorBag();
        $viewErrors->put('default', $validator->errors());
        
        //$vars = $this->validated();
        $vars=$this->all();

        
        
        if($this->isMethod('put')){ //UPDATE  
            $vars['email'] = $this->route('plantilla');
            $vars['academiasSeleccionadas'] = $this->input('academias', []);
            $formVars = TraitFormPlantilla::formularioPlantilla($vars);
            $formVars['sidepanel'] = true;
            $formVars['email'] =$this->route('plantilla');                       
            
            $view = view('plantillas.edit',
                array_merge(
                    $formVars,                    
                    ['errors' => $viewErrors]
                )
            )->render();
        }else{ //CREATE
            $vars['academiasSeleccionadas'] = $this->input('academias', []);
            $formVars = TraitFormPlantilla::formularioPlantilla($vars);
            $formVars['sidepanel'] = true;
            $view = view('plantillas.create',
                array_merge(
                    $formVars,
                    ['errors' => $viewErrors]
                )
            )->render();
        }
                
        throw new HttpResponseException(
            response($view, 422)
        );       
        
    }
}
