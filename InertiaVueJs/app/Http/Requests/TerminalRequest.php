<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class TerminalRequest extends FormRequest
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
        $terminal = $this->route('terminal');

        return [
            'firstname' => ['required'],
            'lastname' => ['required'],
            'email' => ['nullable'],
            'phone_number' => ['required', function ($attribute, $value, $fail) {
                $exists = User::where([
                    'station_id' => $this->station_id,
                    'phone_number' => $value,
                ])->exists();
                if ($exists) {
                    $fail('Le numéro est déjà pris.');
                }
            }],
            'address' => ['nullable'],
            'role_id' => ['nullable'],
            'station_id' => ['required', 'exists:stations,id'],
        ];
    }

    public function attributes()
    {
        return [
            'firstname' => 'Prénom',
            'lastname' => 'Nom de famille',
            'phone_number' => 'Numéro de téléphone',
            'station_id' => 'Station',
        ];
    }
}
