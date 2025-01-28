<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class OrderCancelRequest extends FormRequest
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
        return [
            'item_ids' => 'required|array',
            'item_ids.*' => 'required|integer|exists:order_items,id',
            'reason_id' => 'required|integer|exists:reasons,id',
        ];
    }

    public function failedValidation(Validator $validator): JsonResponse
    {
        $errors = $validator->errors();
        throw new HttpResponseException(validationError('Validation Error', errors: $errors));
    }
}
