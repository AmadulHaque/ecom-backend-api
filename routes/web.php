<?php

use App\Http\Controllers\Frontend\HomeController;
use App\Services\Payments\SslCommerzPayment;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::redirect('/', 'admin/login');
// Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('login', [HomeController::class, 'login'])->name('login');
// ssl
Route::post('/success', [SslCommerzPayment::class, 'success']);
Route::post('/fail', [SslCommerzPayment::class, 'fail']);
Route::post('/cancel', [SslCommerzPayment::class, 'cancel']);
Route::post('/ipn', [SslCommerzPayment::class, 'ipn']);

require __DIR__.'/auth.php';
include base_path('app/Modules/RolePermission/Routes/web.php');
