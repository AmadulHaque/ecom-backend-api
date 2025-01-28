<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;

class CustomerAddress extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'location_id' => ['required', Rule::exists('locations', 'id')->where(function ($query) {
                $query->where('type', 'city');
            }), ],
            'name' => 'required|min:3|max:25',
            'landmark' => 'nullable|max:100',
            'address' => 'required|max:100',
            'address_type' => 'required|in:home,office',
            'contact_number' => 'required|max:15',
        ];

        if ($this->is_default_bill) {
            $rules['is_default_bill'] = 'required|boolean';
        }

        if ($this->is_default_ship) {
            $rules['is_default_ship'] = 'required|boolean';
        }

        return $rules;
    }

    public function failedValidation(Validator $validator): JsonResponse
    {
        $errors = $validator->errors();
        throw new HttpResponseException(validationError('Validation Error', errors: $errors));
    }

    public function messages()
    {
        return [
            'location_id.exists' => 'Please select a valid city',
        ];
    }
}
