<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomerRequest extends FormRequest
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
        $customer = $this->route('customer');

        return [
            'name' => ['nullable'],
            'firstname' => ['required'],
            'lastname' => ['required'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($customer)],
            'phone_number' => ['required'],
            'address' => ['nullable'],
            'active' => ['nullable'],
            'currency' => ['nullable'],
            'role_id' => ['nullable'],
            'app_logo' => ['nullable', 'file', 'image', 'mimes:jpg,jpeg,png'],
            'country_id' => ['required', 'exists:countries,id'],
            'company_id' => ['required', 'exists:companies,id'],
            'products' => ['required', 'array', 'exists:products,id'],
        ];
    }

    public function attributes(): array
    {
        return [
            'country_id' => 'Pays',
            'company_id' => 'Companie',
            'products' => 'Produits',
        ];
    }
}
