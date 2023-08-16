<?php

namespace App\Http\Requests;

use App\Rules\MustStartWithCompanyName;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StationRequest extends FormRequest
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
        $station = $this->route('station');

        return [
            'name' => ['required', new MustStartWithCompanyName],
            'phone_number' => ['required'],
            'region' => ['required'],
            'address' => ['nullable'],
            'manager_email' => ['nullable', Rule::unique('users', 'email')->ignore($station)],
            'manager_phone_number' => ['nullable', Rule::unique('users', 'phone_number')->ignore($station)],
        ];
    }
}
