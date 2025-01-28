<?php

namespace App\Services\Checkout\Calculators;

use App\DTOs\CheckoutData;
use App\Models\Product;
use App\Models\ProductVariation;
use Illuminate\Support\Facades\DB;

class PriceCalculator
{
    public function calculatePrices(CheckoutData $data): array
    {
        $orderItems = [];

        foreach ($data->productIds as $key => $productId) {
            $product = Product::findOrFail($productId);
            $quantity = $data->quantities[$key] ?? throw new \Exception('Product quantity not found');

            $priceData = $this->calculateProductPrice($product, $data->skus[$key] ?? null);

            $orderItems[$product->merchant_id][] = [
                'product_id' => $product->id,
                'product_variation_id' => $priceData['variation_id'],
                'price' => $priceData['price'],
                'quantity' => $quantity,
            ];
        }

        return $orderItems;
    }

    public function calculateTotalPrice(array $orderItems): float
    {
        return collect($orderItems)
            ->flatten(1)
            ->sum(fn ($item) => $item['price'] * $item['quantity']);
    }

    private function calculateProductPrice(Product $product, ?string $sku): array
    {
        $basePrice = $product->productDetail()
            ->select(DB::raw('CASE WHEN discount_price > 0 THEN discount_price ELSE regular_price END AS price'))
            ->first()->price;

        if (! $sku) {
            return ['price' => $basePrice, 'variation_id' => null];
        }

        $variation = ProductVariation::where('product_id', $product->id)
            ->where('sku', $sku)
            ->select(DB::raw('id, CASE WHEN discount_price > 0 THEN discount_price ELSE regular_price END AS price'))
            ->first();

        return $variation
            ? ['price' => $variation->price, 'variation_id' => $variation->id]
            : ['price' => $basePrice, 'variation_id' => null];
    }
}
