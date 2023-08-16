<?php

namespace App\Http\Requests;

use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;

class CreateSessionRequest extends FormRequest
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
            'phone_number' => ['required'],
            'password' => ['required'],
            'submission_channel' => ['nullable'],
            // 'submission_channel' => [function($attribute, $value, $fail) {
            //     if(! in_array($value, [Role::CLIENT, Role::GERANT_STATION, Role::POMPISTE])) {
            //         $fail("Identifiants incorrects");
            //     }
            // }],
        ];
    }

    public function attributes(): array
    {
        return [
            'phone_number' => 'Numéro de téléphone',
            'password' => 'Mot de passe',
        ];
    }
}
