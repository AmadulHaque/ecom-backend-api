<?php

namespace App\Services\Checkout;

use App\DTOs\CheckoutData;
use App\Models\CustomerAddress;
use App\Models\Order;
use App\Services\Checkout\Calculators\CouponDiscount;
use App\Services\Checkout\Calculators\PriceCalculator;
use App\Services\Checkout\Calculators\ShippingCalculator;
use App\Services\Checkout\Processors\MerchantOrderProcessor;
use App\Services\Checkout\Processors\OrderProcessor;
use App\Services\Checkout\Validators\CouponValidator;
use App\Services\Checkout\Validators\StockValidator;
use App\Services\Payments\PaymentFactory;
use App\Traits\Transaction;
use Illuminate\Http\JsonResponse;

class CheckoutService
{
    private ShippingCalculator $shippingCalculator;

    private PriceCalculator $priceCalculator;

    private StockValidator $stockValidator;

    private OrderProcessor $orderProcessor;

    private MerchantOrderProcessor $merchantOrderProcessor;

    private CouponValidator $couponValidator;

    private CouponDiscount $couponDiscount;

    public function __construct(
        ShippingCalculator $shippingCalculator,
        PriceCalculator $priceCalculator,
        StockValidator $stockValidator,
        OrderProcessor $orderProcessor,
        MerchantOrderProcessor $merchantOrderProcessor,
        CouponValidator $couponValidator,
        CouponDiscount $couponDiscount,
    ) {
        $this->shippingCalculator = $shippingCalculator;
        $this->priceCalculator = $priceCalculator;
        $this->stockValidator = $stockValidator;
        $this->orderProcessor = $orderProcessor;
        $this->merchantOrderProcessor = $merchantOrderProcessor;
        $this->couponValidator = $couponValidator;
        $this->couponDiscount = $couponDiscount;
    }

    public function checkout(array $data): JsonResponse
    {
        try {
            return Transaction::rollback(fn () => $this->processCheckout($data));
        } catch (\Exception $e) {
            return failure('Checkout failed: '.$e->getMessage(), 500);
        }
    }

    private function processCheckout(array $data): JsonResponse
    {
        $checkoutData = CheckoutData::fromArray($data);
        $customerAddress = CustomerAddress::findOrFail($checkoutData->customerAddressId);

        // Validate stock before processing
        $this->stockValidator->validate($checkoutData);

        // Calculate prices and shipping
        $orderItems = $this->priceCalculator->calculatePrices($checkoutData);

        $shippingDetails = $this->shippingCalculator->calculate($customerAddress, $orderItems, $checkoutData->deliveryType);

        $totalAmount = $this->priceCalculator->calculateTotalPrice($orderItems);

        // coupon validate and calculate discount
        $coupon = $this->couponValidator->validate($checkoutData, $totalAmount);
        $coupon = [
            'id' => $coupon ? $coupon->id : null,
            'discount_amount' => $coupon ? $this->couponDiscount->calculate($coupon, $totalAmount) : 0,
        ];

        // Create order and related records
        $order = $this->orderProcessor->createOrder($checkoutData, $customerAddress, $orderItems, $shippingDetails, $coupon);
        $this->merchantOrderProcessor->createMerchantOrders($order, $orderItems, $shippingDetails, $coupon);

        // Process payment
        $paymentProcessor = PaymentFactory::getProcessor($checkoutData->paymentMethod);
        $paymentResult = $paymentProcessor->process($order, $data);

        if ($paymentResult['status'] === 'success') {
            return success('Order placed successfully', $paymentResult['data'] ?? [], 201);
        }

        return failure($paymentResult['message'], 500);
    }
}
