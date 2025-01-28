<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CheckoutController;
use App\Http\Controllers\Api\CouponController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PrimeViewController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ReasonController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\ShopController;
use App\Http\Controllers\Api\ShopSettingController;
use App\Http\Controllers\Api\SliderController;
use Illuminate\Support\Facades\Route;

// public routes
Route::post('/v1/send-otp', [AuthController::class, 'sendOtp']);
Route::post('/v1/verify-otp', [AuthController::class, 'verifyOtp']);
Route::post('/v1/register', [AuthController::class, 'register']);

// private routes
Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    Route::post('/customer-address/store', [CustomerController::class, 'customerAddressStore']);
    Route::get('/customer-address/list', [CustomerController::class, 'customerAddressList']);
    Route::get('/location', [LocationController::class, 'location']);

    // products
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/products', [ProductController::class, 'products']);
    Route::get('/product/{slug}', [ProductController::class, 'productDetails']);
    Route::get('/product/{slug}/variant', [ProductController::class, 'productVariant']);
    Route::get('/products/suggestions', [ProductController::class, 'productSuggestions']);

    // format modify products response
    Route::get('/shop/products', [ProductController::class, 'shopProducts']);
    Route::get('/shop/product/{slug}', [ProductController::class, 'shopProductDetails']);

    // checkout
    Route::post('/checkout', [CheckoutController::class, 'checkout']);

    // sliders
    Route::get('/sliders', [SliderController::class, 'index']);

    // PrimeView Products
    Route::get('/prime-view', [PrimeViewController::class, 'primeView']);

    // customer orders
    Route::get('/customer/orders', [CustomerController::class, 'customerOrders']);
    Route::get('/customer/orders/{tracking_id}', [CustomerController::class, 'customerOrderDetails']);
    Route::post('/order/{tracking_id}/items/cancel', [CustomerController::class, 'cancelOrderItem']);
    Route::post('/order/{tracking_id}/items/return', [CustomerController::class, 'returnOrderItem']);

    // my returns
    Route::get('/my/returns', [CustomerController::class, 'customerReturns']);
    Route::get('/my/return/{id}/{tracking_id}', [CustomerController::class, 'returnDetails']);

    // reasons
    Route::get('/reasons', [ReasonController::class, 'reasons']);

    // review routes
    Route::post('/reviews', [ReviewController::class, 'store']);
    Route::get('/product/{slug}/reviews', [ReviewController::class, 'ProductReviews']);
    Route::get('/my/reviews', [ReviewController::class, 'myReviews']);
    Route::get('/to/reviews', [ReviewController::class, 'toReviews']);

    // coupons
    Route::controller(CouponController::class)->group(function () {
        Route::get('/coupons/{product_id}', 'coupons');
        Route::post('/coupon-product-eligibility', 'couponProductEligibility');
    });

    // shop settings
    Route::get('/shop/settings', ShopSettingController::class);

    // Shop Details
    Route::get('/shop/{id}/details', [ShopController::class, 'basicDetails']);
    Route::get('/shop/{id}/products', [ShopController::class, 'shopProducts']);

    // format modify order response
    Route::get('/orders', [OrderController::class, 'shopOrders']);
    Route::get('/order/cancel/{item_id}', [OrderController::class, 'orderCancelDetails']);

});
