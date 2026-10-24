<?php

namespace App\Http\Requests;

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
            'name'      => ['string', 'required', 'min:3'],
            'email'     => ['email:rfc,dns', 'required', 'unique:users'],
            'password'  => ['required', 'confirmed', Password::min(8)->letters()->mixedCase()->numbers()->symbols()]
        ];
    }

    
    public function messages(): array
    {
        return [];
    }

    public function attributes(): array
    {
        return [
            'name'      => 'Nome',
            'email'     => 'E-mail',
            'password'  => 'Senha'
        ];    
    }
}
