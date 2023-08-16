<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
        $user = $this->route('user');

        return [
            'name' => ['nullable'],
            'firstname' => ['required'],
            'lastname' => ['required'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user)],
            'phone_number' => ['required'],
            'address' => ['nullable'],
            'active' => ['nullable'],
            'role_id' => ['nullable'],
        ];
    }
}
