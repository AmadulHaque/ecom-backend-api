<?php

namespace App\DTOs;

use Spatie\LaravelData\Attributes\Validation\Rule;
use Spatie\LaravelData\Data;

class CouponData extends Data
{
    public function __construct(
        #[Rule('required|string|max:255')]
        public string $name,

        #[Rule('required|string|max:50|unique:coupons,code')]
        public string $code,

        #[Rule('required|string|max:50|exists:coupon_types,id')]
        public string $coupon_type_id,

        #[Rule('required|numeric|min:1')]
        public int $discount_value,

        #[Rule('required|numeric|min:0')]
        public int $min_purchase,

        #[Rule('required|numeric|gt:min_purchase')]
        public int $max_purchase,

        #[Rule('required|integer|min:1')]
        public int $usage_limit_per_user,

        #[Rule('required|integer|min:1')]
        public int $usage_limit_total,

        #[Rule('required|in:fixed,percentage')]
        public string $type,

        #[Rule('required|in:active,inactive')]
        public string $status,

        #[Rule('required|date_format:Y-m-d|after_or_equal:today')]
        public string $start_date,

        #[Rule('required|date_format:Y-m-d|after:start_date')]
        public string $end_date,

        #[Rule('nullable|in:1,2')]
        public ?string $merchant_type,

        #[Rule('nullable|in:1,2')]
        public ?string $category_type,

        #[Rule('nullable|in:1,2')]
        public ?string $brand_type,

        #[Rule('nullable|in:1,2')]
        public ?string $product_type,

        #[Rule('required_if:merchant_type,1,2|array')]
        public ?array $merchant_ids,

        #[Rule('required_if:category_type,1,2|array')]
        public ?array $category_ids,

        #[Rule('required_if:brand_type,1,2|array')]
        public ?array $brand_ids,

        #[Rule('required_if:product_type,1,2|array')]
        public ?array $product_ids,

        #[Rule('nullable|array')]
        public ?array $varient,
    ) {}

    public static function rules(): array
    {
        return [
            'merchant_ids.*' => ['required_if:merchant_type,1,2', 'exists:merchants,id'],
            'category_ids.*' => ['required_if:category_type,1,2', 'exists:categories,id'],
            'brand_ids.*' => ['required_if:brand_type,1,2', 'exists:brands,id'],
            'product_ids.*' => ['required_if:product_type,1,2', 'exists:products,id'],
            'varient.*' => ['required_if:product_type,include', 'exists:product_variations,id'],
        ];
    }
}
