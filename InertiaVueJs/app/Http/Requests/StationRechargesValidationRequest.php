<?php

namespace App\Http\Requests;

use App\Models\RechargeStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StationRechargesValidationRequest extends FormRequest
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
            'notice' => ['required', Rule::in([RechargeStatus::VALIDEE, RechargeStatus::REJETEE])],
            'comment' => [$this->notice == RechargeStatus::REJETEE ? 'required' : 'nullable'],
            'rejection_reason_id' => [$this->notice == RechargeStatus::REJETEE ? 'required' : 'nullable'],
        ];
    }
}
