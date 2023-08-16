<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FidelityPointsSettingsRequest extends FormRequest
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
            'minimal_amount' => ['required', 'numeric', 'min:0.1'],
            'earned_points' => ['required', 'numeric', 'min:0.1'],
        ];
    }

    public function attributes()
    {
        return [
            'minimal_amount' => 'Montant minimal',
            'earned_points' => 'Points gagnés',
        ];
    }
}
