<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserWalletRechargeRequest extends FormRequest
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
            'phone_number' => ['required', Rule::exists('users', 'phone_number')],
            'amount' => ['required', 'numeric', 'min:0.1'],
        ];
    }

    public function messages()
    {
        return [
            'phone_number.exists' => 'User with '.$this->phone_number.' phone_number does not exist',
        ];
    }
}
