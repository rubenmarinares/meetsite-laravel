<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

use Illuminate\Support\ViewErrorBag;
use App\Traits\TraitFormAula;


class AulaRequest extends FormRequest
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
            'aula' => ['required','string','max:200'],                        
            'academias' => [Rule::requiredIf($isNotSuperAdmin), 'array'],
            'academias.*' => ['exists:academias,id'],
            'properties.capacidad'=>['required','integer'],            
        ];
    }


    public function messages():array{
        return [
            'aula.required'=>'El campo nombre es obligatorio',            
            'aula.string'=>'El campo nombre debe ser un texto',            
            'aula.max'=>'El campo descripción no debe superar los :max caracteres',
            'academias.required'=>'El campo academias es obligatorio',
            'academias.array'=>'El campo academias debe ser un array',
            'descripcion.max'=>'El campo descripción no debe superar los :max caracteres',
            'properties.capacidad.required'=>"El campo capacidad es obligatorio",
            'properties.capacidad.integer'=>"El campo capacidad debe ser un número entero",
            'properties.capacidad.min'=>"El campo capacidad debe ser mayor que 0",            
        ];
    }



    public function failedValidation(Validator $validator)
    {
        

        $viewErrors = new ViewErrorBag();
        $viewErrors->put('default', $validator->errors());
        
        //$vars = $this->validated();
        $vars=$this->all();

        
        
        if($this->isMethod('put')){ //UPDATE  
            $vars['aula'] = $this->route('aula');
            $vars['academiasSeleccionadas'] = $this->input('academias', []);
            $formVars = TraitFormAula::formularioAula($vars);
            $formVars['sidepanel'] = true;
            $formVars['aula'] =$this->route('aula');                       
            
            $view = view('aulas.edit',
                array_merge(
                    $formVars,                    
                    ['errors' => $viewErrors]
                )
            )->render();
        }else{ //CREATE
            $vars['academiasSeleccionadas'] = $this->input('academias', []);
            $formVars = TraitFormAula::formularioAula($vars);
            $formVars['sidepanel'] = true;
            $view = view('aulas.create',
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
