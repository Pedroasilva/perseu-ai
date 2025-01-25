<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEstanciaPostRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'nome' => ['required', 'min:3', 'max:100'],
            'descricao' => ['max:300', 'required', 'min:3'],
            'telefone' => [
                'digits:11',
                'required',
                Rule::unique('estancia', 'telefone')
                    ->whereNull('deleted_at')
                    ->ignore($this->route('id'))
            ],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function messages(): array
    {
        return [
            'nome.required' => 'O campo nome é obrigatório.',
            'nome.min' => 'O campo nome deve ter no mínimo 3 caracteres.',
            'descricao.required' => 'O campo descrição é obrigatório.',
            'descricao.max' => 'O campo descrição deve ter no máximo 300 caracteres.',
            'descricao.min' => 'O campo descrição deve ter no mínimo 3 caracteres.',
            'telefone.integer' => 'O campo telefone deve ser um número inteiro.',
            'telefone.digits' => 'O campo telefone deve ter 11 dígitos.',
            'telefone.unique' => 'Telefone já cadastrado.',
            'telefone.required' => 'O campo telefone é obrigatório.',
        ];
    }

    public function attributes(): array
    {
        return [
            'nome' => 'nome',
            'descricao' => 'descrição',
            'telefone' => 'telefone',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->input('telefone') && strlen($this->input('telefone')) !== 11) {
                $validator->errors()->add('telefone', 'O campo telefone deve ter 11 dígitos.');
            }
        });
    }

    public function prepareForValidation()
    {
        $this->merge([
            'telefone' => preg_replace('/\D/', '', $this->input('telefone')),
        ]);
    }

    public function failedValidation($validator)
    {
        $this->session()->flash('errors', $validator->errors());
        parent::failedValidation($validator);
    }

    public function failedAuthorization()
    {
        $this->session()->flash('errors', ['Você não tem permissão para acessar essa página.']);
        parent::failedAuthorization();
    }

    public function response(array $errors)
    {
        return redirect()->back()->withInput()->withErrors($errors);
    }
}
