<?php

namespace App\Http\Requests;

use App\Data\Auth\LoginData;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Override;

class LoginFormRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "email" => ['required', 'email:rfc', 'max:255'],
            "password" => ['required', 'max:20']
        ];
    }


    public function messages(): array
    {
        return [
            'required' => "Preencha o campo obrigatório (:attribute)",
            'email.email' => "Digite um e-mail válido",
            'max' => "O campo (:attribute) deve ter no máximo :max"
        ];
    }

    public function attributes(): array
    {
        return [
            'email'     => 'E-mail',
            'password'  => 'Senha'
        ];
    }

    public function paraDto(): LoginData
    {
        return LoginData::from($this->validated());
    }

}
