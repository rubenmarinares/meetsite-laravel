<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

use Illuminate\Support\ViewErrorBag;
use App\Traits\TraitFormGrupo;


/**
 * Class GrupoRequest
 *
 * @method array all($keys = null)        Obtener todos los datos del request
 * @method mixed input($key = null, $default = null) Obtener un campo específico
 * @method bool isMethod(string $method)  Verificar el método HTTP (GET, POST, PUT...)
 * @method mixed route($param = null, $default = null) Obtener parámetro de la ruta
 *
 * @property-read array $errors           Acceso al bag de errores
 */

class GrupoRequest extends FormRequest
{
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
                  
        //$user = auth()->user();
        $user = Auth::user();
        


        $isNotSuperAdmin = !$user || !$user->hasRole('super-admin');
        return [
            'grupo' => ['required','string','max:200'],                        
            'academias' => [Rule::requiredIf($isNotSuperAdmin), 'array'],
            'academias.*' => ['exists:academias,id'],
            //'properties' => ['required','array'],
            'color'=>['required','string','max:200'],
            'textcolor'=>['required','string','max:200'],
            'fechainicio'=>['required'],
            'fechafin'=>['required'],
            'status'=>['required','integer'],
        ];
    }

    public function messages():array{
        return [
            'grupo.required'=>'El campo nombre es obligatorio',                                    
            'academias.required'=>'El campo academias es obligatorio',
            'academias.array'=>'El campo academias debe ser un array',
            'color.required'=>'El campo color es obligatorio',
            'textcolor.required'=>'El campo textcolor es obligatorio',
            'fechainicio.required'=>'El campo fecha de inicio es obligatorio',
            'fechafin.required'=>'El campo fecha de fin es obligatorio',
            'status.required'=>'El campo estado es obligatorio',
            
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $viewErrors = new ViewErrorBag();
        $viewErrors->put('default', $validator->errors());
                
        $vars=$this->all();        
        if($this->isMethod('put')){ //UPDATE  
            $vars['grupo'] = $this->route('grupo');
            $vars['academiasSeleccionadas'] = $this->input('academias', []);
            $formVars = TraitFormGrupo::formularioGrupo($vars);
            $formVars['sidepanel'] = true;
            $formVars['grupo'] =$this->route('grupo');                       
            
            $view = view('grupos.edit',
                array_merge(
                    $formVars,                    
                    ['errors' => $viewErrors]
                )
            )->render();
        }else{ //CREATE
            $vars['academiasSeleccionadas'] = $this->input('academias', []);
            
            $formVars = TraitFormGrupo::formularioGrupo($vars);
            $formVars['sidepanel'] = true;
            $view = view('grupos.create',
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
