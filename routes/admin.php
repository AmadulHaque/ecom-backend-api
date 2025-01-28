<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\ReasonController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\MerchantController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PrimeViewController;
use App\Http\Controllers\Admin\CouponTypeController;
use App\Http\Controllers\Admin\ShopSettingController;
use App\Http\Controllers\Admin\PayoutRequestController;
use App\Http\Controllers\Admin\MerchantReportController;
use App\Http\Controllers\Admin\PrimeViewProductsController;
use App\Http\Controllers\Admin\CategoryCreateRequestController;
use App\Http\Controllers\CategoryImportController;

Route::middleware(['auth:admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::controller(ProductController::class)->group(function () {
        Route::get('/request/products', 'requestProducts')->name('request.products');
        Route::get('/shop/products', 'shopProducts')->name('shop.products');
        Route::patch('/request/product/status', 'requestProductStatus')->name('request.product.status');
        Route::get('/product/{slug}', 'show')->name('product.show');
    });

    Route::controller(MerchantController::class)->as('merchant.')->group(function () {
        Route::get('/merchants', 'index')->name('index');
        Route::get('/merchant/{id}', 'show')->name('show');
        Route::patch('/merchant/{id}/active', 'active')->name('active');
    });

    Route::controller(OrderController::class)->group(function () {
        Route::get('/orders', 'index')->name('orders.index');
        Route::get('/order/merchant/list', 'merchantOrders')->name('merchant.order.list');
        Route::get('/orders/{invoice_id}', 'show')->name('orders.show');
    });

    Route::controller(CustomerController::class)->group(function () {
        Route::get('/customers', 'index')->name('customers.index');
    });

    Route::controller(ShopSettingController::class)->group(function () {
        Route::get('/settings', 'index')->name('settings.index');
        Route::post('/settings', 'update')->name('settings.update');
    });

    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'index')->name('profile.index');
        Route::post('/profile', 'update')->name('profile.update');
        Route::get('/password/update', 'change_password')->name('profile.change_password');
        Route::post('/password/update', 'password_update')->name('profile.password.update');
    });

    Route::controller(PaymentController::class)->group(function () {
        Route::get('/payments', 'index')->name('payments.index');
        Route::get('/payments/{tran_id}', 'show')->name('payments.show');
        Route::put('/payment/{id}/status', 'changeStatus')->name('payments.status.change');
    });

    Route::controller(PageController::class)->group(function () {
        Route::get('/pages', 'index')->name('pages.index');
        Route::get('/page/section/{slug}', 'showSections')->name('pages.show');
        Route::get('/page/section/details/{slug}', 'showSectionDetails')->name('pages.section.show');
        Route::put('/page/section/details/update/{slug}', 'sectionDetailsUpdate')->name('pages.section.update');
    });

    Route::controller(PayoutRequestController::class)->group(function () {
        Route::get('/payout-requests', 'index')->name('payout-requests.index');
        Route::get('/payout-request/{id}', 'show')->name('payout-requests.show');
        Route::patch('/payout-request/{id}', 'statusUpdate')->name('payout-requests.status.update');
    });

    // ----------------------------- all resources routes -----------------------------
    Route::resource('prime-views', PrimeViewController::class); // prime-views route
    Route::resource('prime-view-products', PrimeViewProductsController::class); // prime-view-products
    Route::resource('sliders', SliderController::class); // sliders route
    Route::resource('reasons', ReasonController::class); // reason route
    Route::resource('locations', LocationController::class); // locations route
    Route::resource('coupon-types', CouponTypeController::class); // coupon types route
    Route::resource('coupons', CouponController::class); // coupons route
    Route::resource('category-create-requests', CategoryCreateRequestController::class); // category request
    Route::resource('help-requests', MessageController::class)->only(['index', 'destroy']);
    Route::resource('categories', CategoryController::class); // category route
    Route::resource('merchant-reports', MerchantReportController::class)->only(['destroy','create','store','show']);

    // ajax routes
    Route::get('/merchant-category/products', [ProductController::class, 'MerchantCategoryProducts'])->name('merchant.category.products');
    Route::get('/merchant-brands', [BrandController::class, 'merchantBrands'])->name('merchant.brands');
    Route::get('/product/{id}/variant', [ProductController::class, 'productVariant'])->name('product.variant');
    Route::get('/ajax/merchants', [MerchantController::class, 'ajaxMerchants'])->name('ajax.merchants');

    // import categories from excel file 
    Route::post('/import-categories', [CategoryImportController::class, 'import'])->name('import.categories');
});
