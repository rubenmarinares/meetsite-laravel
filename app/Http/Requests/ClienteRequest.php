<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

use Illuminate\Support\ViewErrorBag;
use App\Traits\TraitFormCliente;



class ClienteRequest extends FormRequest
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
        
        $cliente = $this->route('cliente');

        $isNotSuperAdmin = !$user || !$user->hasRole('super-admin');
        return [
            'nombre' => ['required','string','max:255'],
            'apellidos' => ['required','string','max:255'],
            'email'=>['required','string','max:200','email',Rule::unique('clientes', 'email')->ignore(optional($cliente)->id)],
            'academias' => [Rule::requiredIf($isNotSuperAdmin), 'array'],
            'academias.*' => ['exists:academias,id'],
        ];
    }


    public function messages():array{
         return [
            'nombre.required'=>'El campo nombre es obligatorio',            
            'nombre.string'=>'El campo nombre debe ser un texto',
            'nombre.max'=>'El campo nombre no debe superar los :max caracteres',
            'apellidos.required'=>'El campo apellidos es obligatorio',
            'apellidos.string'=>'El campo apellidos debe ser un texto',
            'apellidos.max'=>'El campo apellidos no debe superar los :max caracteres',
            'email.required'=>'El campo email es obligatorio',
            'email.validation'=>'El campo email tiene un formato inválido',
            'email.unique'=>'El campo email ya está en uso',
            'email.string'=>'El campo email debe ser un texto',             
            'academias.required'=>'El campo academias es obligatorio',
            'academias.array'=>'El campo academias debe ser un array',
        ];
    }


    public function failedValidation(Validator $validator)
    {
        

        $viewErrors = new ViewErrorBag();
        $viewErrors->put('default', $validator->errors());
        
        //$vars = $this->validated();
        $vars=$this->all();

        
        
        if($this->isMethod('put')){ //UPDATE  
            $vars['cliente'] = $this->route('cliente');
            $vars['academiasSeleccionadas'] = $this->input('academias', []);
            $vars['alumnosPreSelected'] = $this->input('alumnos', []);
            var_dump($vars['alumnosPreSelected']);
            $formVars = TraitFormCliente::formularioCliente($vars);
            $formVars['sidepanel'] = true;
            $formVars['cliente'] =$this->route('cliente');                       
            
            $view = view('clientes.edit',
                array_merge(
                    $formVars,                    
                    ['errors' => $viewErrors]
                )
            )->render();
        }else{ //CREATE
            $vars['academiasSeleccionadas'] = $this->input('academias', []);
            $vars['alumnosSelected'] = $this->input('alumnos', []);
            $vars['alumnosPreSelected'] = $this->input('alumnos', []);
            var_dump($vars['alumnosPreSelected']);
            $formVars = TraitFormCliente::formularioCliente($vars);
            $formVars['sidepanel'] = true;
            $view = view('clientes.create',
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
