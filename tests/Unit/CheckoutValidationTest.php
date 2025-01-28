<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutValidationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_validates_the_checkout_request()
    {
        $response = $this->postJson('/api/v1/checkout', []);
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'customer_address_id',
                'delivery_type',
                'payment_method',
                'product_id',
                'quantity',
            ]);
    }

    /** @test */
    // public function it_validates_the_checkout_request_with_valid_data()
    // {
    //     $customerAddressId = $this->createCustomerHierarchy()->id;
    //     $productId = $this->createProductHierarchy()->id;
    //     $response = $this->postJson('/api/v1/checkout', [
    //         'customer_address_id' => $customerAddressId,
    //         'delivery_type' => 1,
    //         'payment_method' => 'COD',
    //         'product_id' => [$productId],
    //         'quantity' => [1],
    //     ]);
    //     $response->assertStatus(200)
    //         ->assertJson([
    //             'status' => 'success',
    //         ]);
    // }

}
