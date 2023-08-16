<?php

namespace App\Http\Requests;

use App\Models\PurchaseOrderStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PurchaseOrderValidationRequest extends FormRequest
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
            'notice' => ['required', Rule::in(PurchaseOrderStatus::VALIDEE, PurchaseOrderStatus::REJETEE)],
            'comment' => [$this->notice === PurchaseOrderStatus::REJETEE ? 'required' : 'nullable'],
        ];
    }
}
