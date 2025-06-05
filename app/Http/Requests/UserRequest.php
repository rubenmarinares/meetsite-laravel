<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;



class UserRequest extends FormRequest
{

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
        
        $isCreating = request()->isMethod('post');
        // If the request is for creating a new user, 'required' is needed for password

         $userAuth = auth()->user();

        $isNotSuperAdmin = !$userAuth || !$userAuth->hasRole('super-admin');

        

        return [
            'name' => ['required','string','max:255'],
            'email'=>['required','string','max:200','email',Rule::unique('users','email')->ignore($this->route('user'))],                        
            'password' => [
                            $isCreating ? 'required' : 'nullable',
                            'confirmed', Password::defaults()],
            'roles' => [Rule::requiredIf($isNotSuperAdmin), 'array'],
            //'roles.*' => ['exists:roles,id'],
            'academias' => [Rule::requiredIf($isNotSuperAdmin), 'array'],
            //'academias.*' => ['exists:academias,id'],
        ];
    }


    public function messages():array{
        return [
            'name.required'=>'El campo nombre es obligatorio',
            'name.unique'=>'El campo nombre ya está en uso',
            'name.string'=>'El campo nombre debe ser un texto',
            'name.max'=>'El campo nombre no debe superar los :max caracteres',
            'email.required'=>'El campo email es obligatorio',
            'email.unique'=>'El campo email ya está en uso',
            'email.string'=>'El campo email debe ser un texto',       
            'password.unique'=>'El campo contraseña ya está en uso',
            'password.required'=>'El campo contraseña es obligatorio',
            'password.string'=>'El campo contraseña debe ser un texto',
            'password.max'=>'El campo contraseña no debe superar los :max caracteres',   
            'password.min'=>'El campo contraseña debe superar los :min caracteres',   
            'password.confirmed'=>'El campo contraseña ser igual que el campo confirmar contraseña',   
            'roles.required'=>'El campo roles es obligatorio',
            'roles.array'=>'El campo roles debe ser un array',
            'academias.required'=>'El campo academias es obligatorio',
            'academias.array'=>'El campo academias debe ser un array',
        ];
    }
}
