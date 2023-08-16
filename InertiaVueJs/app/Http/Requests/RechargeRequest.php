<?php

namespace App\Http\Requests;

use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RechargeRequest extends FormRequest
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
            'amount' => ['required', 'numeric'],
            'user_type' => ['required', Rule::in([Role::GERANT_STATION, Role::POMPISTE])],
            'terminal_id' => Rule::when($this->user_type === Role::POMPISTE, ['required', 'exists:users,id'], ['nullable']),
            'user_id' => ['required', 'exists:users,id'],
            'station_id' => ['nullable'],
        ];
    }

    public function attributes(): array
    {
        return [
            'amount' => 'Montant',
            'user_id' => 'Compte',
            'terminal_id' => 'Terminal',
            'user_type' => "Type d'utilisateur",
        ];
    }
}
