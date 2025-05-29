<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class AcademiaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function attributes()
    {
       return trans('academia.attributes');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'academia'=>['required','string','max:200',Rule::unique('academias','academia')->ignore($this->route('academia'))],            
            'status'=>['boolean'],
            'properties.capacidad'=>['required','integer'],            
            'properties.tipo'=>['required','string','max:200'],
            'direccion'=>['required','string','max:400'],
            'localidad'=>['required','string','max:100'],
        ];
    }

    public function messages()
    {
        return [
            'academia.required'=>__('academia.academia_required'),
            'academia.unique'=>__('academia.academia_unique'),
            'academia.string'=>'El campo academia debe ser un texto',
            'academia.max'=>__('academia.academia_max'),
            'direccion.required'=>__('academia.direccion_required'),
            'direccion.max'=>__('academia.direccion_max'),
            'localidad.required'=>__('academia.localidad_required'),
            'localidad.max'=>__('academia.localidad_max'),            
            'properties.capacidad.required'=>__('academia.capacidad_required'),
            'properties.capacidad.integer'=>__('academia.capacidad_integer'),
            'properties.tipo.required'=>__('academia.tipo_required'),
        ];
    }
}
