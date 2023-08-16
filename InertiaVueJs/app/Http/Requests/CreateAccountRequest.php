<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class CreateAccountRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'phone_number' => ['required', 'string', Rule::unique('users', 'phone_number')],
            'password' => ['required', Password::min(5)],
            'firstname' => ['required'],
            'lastname' => ['required'],
            'name' => ['nullable'],
            'dialing_code' => ['required'],
        ];
    }

    public function attributes()
    {
        return [
            'phone_number' => 'Numéro de téléphone',
            'password' => 'Mot de passe',
            'firstname' => 'Prénom',
            'lastname' => 'Nom de famille',
            'name' => 'Nom complet',
            'dialing_code' => 'Code de numérotation',
        ];
    }
}
