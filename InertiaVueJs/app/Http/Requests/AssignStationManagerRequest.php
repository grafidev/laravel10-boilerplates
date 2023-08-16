<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AssignStationManagerRequest extends FormRequest
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
            'firstname' => ['required'],
            'lastname' => ['required'],
            'email' => ['required', Rule::unique('users', 'email')],
            'phone_number' => ['required', Rule::unique('users', 'phone_number')],
        ];
    }

    public function attributes(): array
    {
        return [
            'firstname' => 'Prénom',
            'lastname' => 'Nom de famille',
            'email' => 'Adresse email',
            'phone_number' => 'Numéro de téléphone',
        ];
    }
}
