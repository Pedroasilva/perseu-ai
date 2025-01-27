<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MensagemPostRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'instancia_id' => ['required', 'exists:instancia,id'],
            'destinatario' => ['required', 'digits:11'],
            'mensagem' => ['required', 'max:300'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function messages(): array
    {
        return [
            'instancia_id.required' => 'O campo estância é obrigatório.',
            'instancia_id.exists' => 'Instancia não encontrada.',
            'destinatario.required' => 'O campo destinatario é obrigatório.',
            'destinatario.digits' => 'O campo destinatario deve ter 11 dígitos.',
            'mensagem.required' => 'O campo mensagem é obrigatório.',
            'mensagem.max' => 'O campo mensagem deve ter no máximo 300 caracteres.',
        ];
    }

    public function attributes(): array
    {
        return [
            'instancia_id' => 'instancia_id',
            'destinatario' => 'destinatario',
            'mensagem' => 'mensagem',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->input('destinatario') && strlen($this->input('destinatario')) !== 11) {
                $validator->errors()->add('destinatario', 'O campo destinatario deve ter 11 dígitos.');
            }
        });
    }

    public function prepareForValidation()
    {
        $this->merge([
            'destinatario' => preg_replace('/\D/', '', $this->input('destinatario')),
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
