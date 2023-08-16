<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AnomalyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if ($this->isMethod('post') && $this->user()->can('create_anomaly')) {
            return true;
        }

        if ($this->isMethod('put') && $this->user()->can('edit_anomaly')) {
            return true;
        }

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *p
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'label' => ['required'],
            'date_of_finding' => ['required', 'date'],
        ];
    }

    public function attributes()
    {
        return [
            'label' => 'Libellé',
            'date_of_finding' => 'Date',
        ];
    }
}
