<?php

namespace App\Http\Requests;

use App\Models\Advertisement;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdvertisementRequest extends FormRequest
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
        $advertisement = $this->route('advertisement');

        return [
            'title' => ['required'],
            'description' => ['required'],
            'type' => ['required', Rule::in(array_keys(Advertisement::TYPES))],
            'file' => Rule::when($advertisement === null, ['required', 'file', 'max:2048'], ['nullable']),
            'content' => ['nullable'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after:start_date'],
        ];
    }

    public function attributes(): array
    {
        return [
            'title' => 'Titre',
            'description' => 'Description',
            'type' => 'Type',
            'file' => 'Fichier',
            'content' => 'Contenu',
            'start_date' => 'Date de début',
            'end_date' => 'Date de fin',
        ];
    }
}
