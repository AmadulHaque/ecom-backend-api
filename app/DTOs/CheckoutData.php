<?php

namespace App\DTOs;

class CheckoutData
{
    public array $productIds;

    public array $skus;

    public array $quantities;

    public int $customerAddressId;

    public string $deliveryType;

    public string $paymentMethod;

    public ?string $coupon_code;

    public static function fromArray(array $data): self
    {
        $dto = new self;
        $dto->productIds = $data['product_id'];
        $dto->skus = $data['sku'] ?? [];
        $dto->quantities = $data['quantity'];
        $dto->customerAddressId = $data['customer_address_id'];
        $dto->deliveryType = $data['delivery_type'];
        $dto->paymentMethod = $data['payment_method'];
        $dto->coupon_code = $data['coupon_code'];

        return $dto;
    }
}
