<?php

namespace App\Http\Requests;

use App\Data\Auth\RegisterDataDto;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Override;

class RegisterUserFormRequest extends FormRequest
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
            'name'      => ['string', 'required', 'min:3', 'max:255'],
            'email'     => ['email:rfc,dns', 'required', 'unique:users', 'max:255'],
            'password'  => ['required', 'confirmed', Password::min(8)->max(20)->letters()->mixedCase()->numbers()->symbols()]
        ];
    }


    public function messages(): array
    {
        return [
            'required' => "Preencha o campo obrigatório (:attribute)",
            'min' => "O campo (:attribute) deve ter no mínimo :min",
            'max' => "O campo (:attribute) deve ter no máximo :max",
            'email.email' => "Digite um e-mail válido",
            'email.unique' => "Este e-mail já está cadastrado",
            'confirmed' => "A confirmação do campo (:attribute) não confere"
        ];
    }

    public function attributes(): array
    {
        return [
            'name'      => 'Nome',
            'email'     => 'E-mail',
            'password'  => 'Senha'
        ];
    }

    public function paraDto(): RegisterDataDto
    {
        return RegisterDataDto::createDto($this->toArray());
    }
}
