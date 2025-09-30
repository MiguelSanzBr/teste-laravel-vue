<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'cnpj' => [
                'required', 
                'string', 
                'max:18', 
                Rule::unique(User::class)->ignore($this->user()->id)
            ],
            'nmfs' => [
                'required', 
                'string', 
                'max:255'
            ],
            'rsl' => [
                'required', 
                'string', 
                'max:255'
            ],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'cnpj' => 'CNPJ',
            'nmfs' => 'Nome Fantasia',
            'rsl' => 'Razão Social',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'cnpj.required' => 'O campo CNPJ é obrigatório.',
            'cnpj.unique' => 'Este CNPJ já está em uso.',
            'cnpj.max' => 'O CNPJ deve ter no máximo 18 caracteres.',
            'nmfs.required' => 'O campo Nome Fantasia é obrigatório.',
            'nmfs.max' => 'O Nome Fantasia deve ter no máximo 255 caracteres.',
            'rsl.required' => 'O campo Razão Social é obrigatório.',
            'rsl.max' => 'A Razão Social deve ter no máximo 255 caracteres.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        // Remove caracteres não numéricos do CNPJ antes da validação
        if ($this->has('cnpj')) {
            $this->merge([
                'cnpj' => preg_replace('/[^0-9]/', '', $this->cnpj),
            ]);
        }
    }
}
