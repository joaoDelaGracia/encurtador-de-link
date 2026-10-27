<?php

namespace App\Http\Requests;

use App\Data\Link\RegisterLinkDto;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RegisterLinkFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'originalUrl' => ['required', 'string', 'max:2048', 'url'],
            'title' => ['required', 'string', 'max:255'],
            'expiresAt' => ['nullable', 'date']
        ];
    }

    public function messages(): array 
    {
        return [
            'required' => 'Preenche o campo obrigatório (:attribute)',
            'max' => 'O campo (:attribute) deve ter no máximo :max caracteres',
            'url' => 'Por favor, digite uma url válida em (:attribute)',
            'date' => 'Data inválida'
        ];
    }

    public function attributes(): array
    {
        return [
            'originalUrl' => 'Url de destino',
            'title' => 'Nome do link',
            'expiresAt' => 'Data de expiração'
        ];
    }

    public function paraDto(): RegisterLinkDto
    {
        return RegisterLinkDto::from($this->toArray());
    }

}
