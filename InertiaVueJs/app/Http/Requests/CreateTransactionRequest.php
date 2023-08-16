<?php

namespace App\Http\Requests;

use App\Models\TransactionType;
use App\Models\User;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class CreateTransactionRequest extends FormRequest
{
    /**
     * Indicates if the validator should stop on the first rule failure.
     *
     * @var bool
     */
    protected $stopOnFirstFailure = true;

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
        $data = [
            'amount' => ['required', 'min:0.01'],
            'receiver_phone_number' => ['bail', 'required', 'exists:users,phone_number', function ($attribute, $value, $fail) {
                $receiver = User::firstWhere('phone_number', $value);
                if (! $receiver->wallet) {
                    $fail('Receiver wallet does not exists');
                }
            }],
            'sender_phone_number' => ['bail', 'required', 'exists:users,phone_number', function ($attribute, $value, $fail) {
                $sender = User::firstWhere('phone_number', $value);
                if (! $sender->wallet) {
                    $fail('Sender wallet does not exists');
                }
            }, 'different:receiver_phone_number'],
            'transaction_type' => ['required', Rule::in([
                TransactionType::RECHARGE,
                TransactionType::ACHAT,
            ]), 'exists:transaction_types,slug'],
            'quantity' => ['nullable', 'numeric'],
        ];

        if ($this->transaction_type === TransactionType::ACHAT) {
            $data['product_slug'] = ['required', 'exists:products,slug'];
        }

        return $data;
    }

    public function messages(): array
    {
        return [
            'receiver_phone_number.exists' => 'Receiver not found',
            'sender_phone_number.exists' => 'Sender not found',
            'transaction_type.exists' => 'Transaction type not found',
            'sender_phone_number.different' => 'Sender wallet is the same as receiver wallet',
            'product_slug.exists' => 'Product not found',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();

        $this->merge(['failure_reason' => $errors->toJson()]);

        $response['message'] = $errors;

        throw new HttpResponseException(response()->json($response, 422));
    }
}
