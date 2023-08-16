<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CardHolderRequest extends FormRequest
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
            'email' => ['required'],
            'vehicle_registration_number' => ['nullable'],
        ];
    }

    public function attributes(): array
    {
        return [
            'vehicle_registration_number' => "Numéro d'immatriculation du véhicule",
            'name' => 'Nom',
            'phone_number' => 'Numéro de téléphone',
            'email' => 'Adresse email',
        ];
    }
}
