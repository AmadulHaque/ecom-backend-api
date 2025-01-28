<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\CustomerAddress;
use App\Models\Location;
use App\Models\Product;
use App\Models\ProductDetails;
use App\Models\ProductType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

// use Tests\Traits\CheckoutTestHelper;

class CheckoutServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_location_service()
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
        $customerAddress = CustomerAddress::factory()->create([
            'location_id' => $city->id,
            'user_id' => $this->user->id,
        ]);
        $category = Category::factory()->create();
        $product_type = ProductType::firstOrCreate(['name' => 'Single']); // Single or Variant
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'merchant_id' => $this->user->id,
            'product_type_id' => $product_type->id,
        ]);
        $productDetails = ProductDetails::factory()->create(['product_id' => $product->id]);

        $this->assertDatabaseHas('locations', [
            'id' => $division->id,
            'type' => 'division',
        ]);
        $this->assertDatabaseHas('locations', [
            'id' => $district->id,
            'type' => 'district',
            'parent_id' => $division->id,
        ]);
        $this->assertDatabaseHas('locations', [
            'id' => $city->id,
            'type' => 'city',
            'parent_id' => $district->id,
        ]);
        $this->assertDatabaseHas('customer_addresses', [
            'id' => $customerAddress->id,
            'location_id' => $city->id,
            'user_id' => $this->user->id,
        ]);
        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => $category->name,
        ]);
        $this->assertDatabaseHas('product_types', [
            'id' => $product_type->id,
            'name' => $product_type->name,
        ]);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => $product->name,
        ]);
        $this->assertDatabaseHas('product_details', [
            'id' => $productDetails->id,
            'product_id' => $product->id,
        ]);
    }
}
