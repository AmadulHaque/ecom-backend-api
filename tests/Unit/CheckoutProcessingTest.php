<?php

namespace Tests\Unit;

use App\Enums\DeliveryType;
use App\Enums\PaymentMethod;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\CheckoutTestHelper;

class CheckoutProcessingTest extends TestCase
{
    use CheckoutTestHelper, RefreshDatabase;

    /** @test */
    public function it_processes_checkout_successfully()
    {
        $customerAddress = $this->createCustomerHierarchy();
        $product = $this->createProductHierarchy();

        // Arrange : Create a customer and product hierarchy
        $payload = [
            'customer_address_id' => $customerAddress->id,
            'delivery_type' => DeliveryType::REGULAR->value,
            'payment_method' => PaymentMethod::COD->value,
            'product_id' => [$product->id],
            'quantity' => [1],
        ];

        // Act : Create a checkout payload with an invalid payment method
        $response = $this->postJson('/api/v1/checkout', $payload);
        // $response->dump();

        $response->assertStatus(201)
            ->assertJson([
                'message' => 'Order placed successfully',
                'data' => [],
            ]);
    }
}
