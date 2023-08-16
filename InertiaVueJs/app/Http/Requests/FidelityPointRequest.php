<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FidelityPointRequest extends FormRequest
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
            'points_required' => ['required', 'numeric'],
            'fidelity_value' => ['required', 'numeric'],
            'active' => ['nullable'],
        ];
    }

    public function attributes()
    {
        return [
            'points_required' => 'Points requis',
            'fidelity_value' => 'Valeur',
        ];
    }
}
