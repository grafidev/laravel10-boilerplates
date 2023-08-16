<?php

namespace App\Http\Requests;

use App\Models\EndowmentStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EndowmentValidationRequest extends FormRequest
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
            'notice' => ['required', Rule::in([EndowmentStatus::VALIDEE, EndowmentStatus::REJETEE])],
            'comment' => $this->notice == EndowmentStatus::REJETEE ? ['required'] : ['nullable'],
        ];
    }

    public function attributes(): array
    {
        return [
            'notice' => 'Avis',
            'comment' => 'Commentaire',
        ];
    }
}
