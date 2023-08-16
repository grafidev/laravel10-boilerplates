<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CorporateClientRequest extends FormRequest
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
        $corporate_client = $this->route('corporate_client');

        return [
            'name' => ['required'],
            'ninea' => ['required', Rule::unique('corporate_clients', 'ninea')->ignore($corporate_client)],
            'address' => ['required'],
            'email' => ['required', Rule::unique('corporate_clients', 'email')->ignore($corporate_client)],
            'phone_number' => ['required', Rule::unique('corporate_clients', 'phone_number')->ignore($corporate_client)],
            'contact_name' => ['nullable'],
            'contact_email' => ['nullable'],
            'contact_phone_number' => ['nullable'],
            'commercial_register_number' => ['nullable', 'required', Rule::unique('corporate_clients', 'commercial_register_number')->ignore($corporate_client)],
            'regime' => ['required'],
            'discount' => ['nullable'],
            'currency' => ['nullable'],
            'periodicity' => ['nullable'],
        ];
    }
}
