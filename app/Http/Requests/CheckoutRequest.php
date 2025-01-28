<?php

namespace App\Http\Requests;

use App\Enums\DeliveryType;
use App\Enums\PaymentMethod;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CheckoutRequest extends FormRequest
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
        $deliveryTypes = implode(',', array_column(DeliveryType::cases(), 'value'));
        $methods = implode(',', array_column(PaymentMethod::cases(), 'value'));

        return [
            'customer_address_id' => 'required|exists:customer_addresses,id',
            'delivery_type' => "required|in:$deliveryTypes",
            'payment_method' => "required|in:$methods",
            'product_id' => 'required|array',
            'product_id.*' => 'required|exists:products,id|exists:shop_products,product_id',
            'sku' => 'nullable|array',
            'sku.*' => 'nullable|exists:product_variations,sku',
            'quantity' => 'required|array',
            'quantity.*' => 'required|numeric|min:1',
            // 'shipping_type' => 'required',
            'coupon_code' => 'nullable|exists:coupons,code',
        ];
    }

    public function messages(): array
    {
        return [
            'customer_address_id.required' => 'Please select an address',
            'customer_address_id.exists' => 'The selected address is invalid',
        ];
    }

    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'The given data was invalid.',
            'errors' => $validator->errors(),
        ], 422));
    }
}
