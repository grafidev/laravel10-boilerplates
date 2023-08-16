<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AppSettingRequest extends FormRequest
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
            'app_logo' => ['nullable', 'file', 'image', 'max:2048'],
            'bg_image' => ['nullable', 'file', 'image', 'max:2048'],
            'app_name' => ['required'],
            'app_primary_color' => ['required'],
            'app_secondary_color' => ['required'],
        ];
    }

    public function attributes(): array
    {
        return [
            'app_logo' => 'Logo',
            'app_name' => 'Nom',
            'app_primary_color' => 'Couleur primaire',
            'app_secondary_color' => 'Couleur secondaire',
            'bg_image' => 'Arrière plan',
        ];
    }
}
