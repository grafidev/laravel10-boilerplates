<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApplyEndowmentRequest extends FormRequest
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
            'dotation_type' => ['required', 'in:value,liter'],
            'dotation_value' => $this->dotation_type == 'value' ? ['required'] : ['nullable'],
            'product_id' => $this->dotation_type == 'liter' ? ['required'] : ['nullable'],
            'quantity' => $this->dotation_type == 'liter' ? ['required', 'min:1'] : ['nullable'],
            'current_price' => $this->dotation_type == 'liter' ? ['required'] : ['nullable'],
            'value' => $this->dotation_type == 'liter' ? ['required'] : ['nullable'],
        ];
    }
}
