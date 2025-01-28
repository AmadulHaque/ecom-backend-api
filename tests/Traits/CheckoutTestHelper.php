<?php

namespace Tests\Traits;

use App\Models\Category;
use App\Models\CustomerAddress;
use App\Models\Location;
use App\Models\Product;
use App\Models\ProductDetails;
use App\Models\ProductType;
use Illuminate\Foundation\Testing\RefreshDatabase;

trait CheckoutTestHelper
{
    use RefreshDatabase;

    public function createLocationHierarchy()
    {
        $division = Location::factory()->create(['type' => 'division']);
        $district = Location::factory()->create([
            'type' => 'district',
            'parent_id' => $division->id,
        ]);
        $city = Location::factory()->create([
            'type' => 'city',
            'parent_id' => $district->id,
        ]);

        return compact('division', 'district', 'city');
    }

    public function createCustomerHierarchy()
    {
        $city = $this->createLocationHierarchy()['city'];

        return $customerAddress = CustomerAddress::factory()->create([
            'location_id' => $city->id,
            'user_id' => $this->user->id,
        ]);
    }

    public function createProductHierarchy()
    {
        $category = Category::factory()->create();
        $product_type = ProductType::create(['name' => 'Single']); // Single or Variant

        $product = Product::factory()->create([
            'category_id' => $category->id,
            'merchant_id' => $this->user->id,
            'product_type_id' => $product_type->id,
        ]);
        $productDetails = ProductDetails::factory()->create(['product_id' => $product->id]);

        return $product;
    }
}
