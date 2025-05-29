<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Role;
use Illuminate\Validation\Rule;

class RoleRequest extends FormRequest
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
        return [
            'name'=>['required','string','max:200',Rule::unique('roles','name')->ignore($this->route('role'))],            
            'guard_name'=>['required','string','max:200',Rule::in(Role::guardName())],            
        ];
    }


    public function messages():array{
        return [
            'name.required'=>'El campo nombre es obligatorio',
            'name.unique'=>'El campo nombre ya está en uso',
            'name.string'=>'El campo nombre debe ser un texto',
            'name.max'=>'El campo nombre no debe superar los :max caracteres',
            'guard_name.required'=>'El campo guard_name es obligatorio',
            'guard_name.unique'=>'El campo guard_name ya está en uso',
            'guard_name.string'=>'El campo guard_name debe ser un texto',
            'guard_name.max'=>'El campo guard_name no debe superar los :max caracteres',  
            'guard_name.in'=>'El campo guard_name debe ser uno de los siguientes valores: '.implode(', ',Role::guardName()),
        ];
    }
}
