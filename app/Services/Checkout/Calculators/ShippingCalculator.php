<?php

namespace App\Services\Checkout\Calculators;

use App\Enums\DeliveryType;
use App\Models\CustomerAddress;
use App\Models\ShopSetting;

class ShippingCalculator
{
    public function calculate(CustomerAddress $address, array $orderItems, string $deliveryType): array
    {
        $deliveryCharge = $this->calculateDeliveryCharge($deliveryType);
        $shippingType = $this->determineShippingType($address);
        $shippingFee = $this->calculateShippingFee($shippingType);

        return [
            'shipping_type' => $shippingType,
            'shipping_fee' => $shippingFee * count($orderItems),
            'delivery_charge' => $deliveryCharge * count($orderItems),
            'shipping_fee_per_item' => $shippingFee,
            'delivery_charge_per_item' => $deliveryCharge,
        ];
    }

    private function calculateDeliveryCharge(int $deliveryType): float
    {
        if ($deliveryType === DeliveryType::EXPRESS->value) {

            return ShopSetting::where('key', 'delivery_charge')->first()?->value ?? 0;
        }

        return 0;
    }

    private function determineShippingType(CustomerAddress $address): string
    {
        $isdSetting = ShopSetting::where('key', 'shipping_isd')->first();

        if ($isdSetting && $isdSetting->value) {
            $isdLocations = array_map('trim', explode(',', $isdSetting->value));
            if (in_array($address->location_id, $isdLocations)) {
                return 'ISD';
            }
        }

        return 'OSD';
    }

    private function calculateShippingFee(string $shippingType): float
    {
        $setting = ShopSetting::where('key', "shipping_fee_$shippingType")->first();

        return $setting?->value ?? 0;
    }
}
