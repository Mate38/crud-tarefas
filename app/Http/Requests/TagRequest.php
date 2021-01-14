<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TagRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $codRules = ['required', 'max:20', 'min:3'];
        if(!$this->tag || $this->cod != $this->tag->cod) {
            array_push($codRules, 'unique:tags');
        };

        return [
            'cod' => $codRules,
            'title' => ['required', 'max:50', 'min:3'],
            'description' => ['max:100'],
        ];
    }

    public function messages() {   
        return [     
            'required' => 'O campo é obrigatório',
            'max' => 'O valor informado deve ter no máximo :max caracteres',
            'min' => 'O valor informado deve ter no mínimo :min caracteres',
        ]; 
    }
}
