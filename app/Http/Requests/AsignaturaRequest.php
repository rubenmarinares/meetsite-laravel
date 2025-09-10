<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

use Illuminate\Support\ViewErrorBag;
use App\Traits\TraitFormAsignatura;



/**
 * Class AsignaturaRequest
 *
 * @method array all($keys = null)        Obtener todos los datos del request
 * @method mixed input($key = null, $default = null) Obtener un campo específico
 * @method bool isMethod(string $method)  Verificar el método HTTP (GET, POST, PUT...)
 * @method mixed route($param = null, $default = null) Obtener parámetro de la ruta
 *
 * @property-read array $errors           Acceso al bag de errores
 */
 

class AsignaturaRequest extends FormRequest
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
            'asignatura' => ['required','string','max:200'],            
            'descripcion' => ['nullable','string','max:500'],            
            'academias' => [Rule::requiredIf($isNotSuperAdmin), 'array'],
            'academias.*' => ['exists:academias,id'],
        ];
    }


    public function messages():array{
        return [
            'asignatura.required'=>'El campo nombre es obligatorio',            
            'asignatura.string'=>'El campo nombre debe ser un texto',            
            'asignatura.max'=>'El campo descripción no debe superar los :max caracteres',
            'academias.required'=>'El campo academias es obligatorio',
            'academias.array'=>'El campo academias debe ser un array',
            'descripcion.max'=>'El campo descripción no debe superar los :max caracteres',
        ];
    }


    public function failedValidation(Validator $validator)
    {
        

        $viewErrors = new ViewErrorBag();
        $viewErrors->put('default', $validator->errors());
        
        //$vars = $this->validated();
        $vars=$this->all();

        
        
        if($this->isMethod('put')){ //UPDATE  
            $vars['asignatura'] = $this->route('asignatura');
            $vars['academiasSeleccionadas'] = $this->input('academias', []);
            $formVars = TraitFormAsignatura::formularioAsignatura($vars);
            $formVars['sidepanel'] = true;
            $formVars['asignatura'] =$this->route('asignatura');                       
            
            $view = view('asignaturas.edit',
                array_merge(
                    $formVars,                    
                    ['errors' => $viewErrors]
                )
            )->render();
        }else{ //CREATE
            $vars['academiasSeleccionadas'] = $this->input('academias', []);
            $formVars = TraitFormAsignatura::formularioAsignatura($vars);
            $formVars['sidepanel'] = true;
            $view = view('asignaturas.create',
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
