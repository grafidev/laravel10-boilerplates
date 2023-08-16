<?php

namespace App\Http\Requests;

use App\Models\OrderRequestStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderRequestValidationRequest extends FormRequest
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
            'notice' => ['required', Rule::in([
                OrderRequestStatus::VALIDATED,
                OrderRequestStatus::REJECTED,
            ])],
            'comment' => ['required', 'string'],
            'order_request_status_id' => ['required', 'exists:order_request_statuses,id'],
            'rejection_reason_id' => [
                Rule::requiredIf($this->notice === OrderRequestStatus::REJECTED),
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'notice' => 'Avis',
            'comment' => 'Commentaire',
            'rejection_reason_id' => 'Raison de rejet',
            'files' => 'Fichiers',
        ];
    }
}
