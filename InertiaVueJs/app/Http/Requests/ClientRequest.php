<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
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
            'phone_number' => ['required'],
            'password' => ['required', 'regex:/^[0-9]{5}$/'],
        ];
    }

    public function attributes(): array
    {
        return [
            'firstname' => 'Prénom',
            'lastname' => 'Nom de famille',
            'phone_number' => 'Numéro de téléphone',
        ];
    }
}
