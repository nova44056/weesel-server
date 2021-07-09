<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Category\CategoryChildrenController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Category\CategoryProductController;
use App\Http\Controllers\Order\OrderController;
use App\Http\Controllers\Product\ProductCollectionController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\UserOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    "prefix" => "auth"
], function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::get('refresh', [AuthController::class, 'refresh']);
    Route::group(['middleware' => ['jwt.verify']], function () {
        Route::get('user', [AuthController::class, 'getAuthenticatedUser']);
        Route::get('logout', [AuthController::class, 'logout']);
    });
});

Route::resource("users", UserController::class)->only(['show']);
Route::resource("users.orders", UserOrder::class)->only(['index']);

// Route::get('products', [ProductController::class, 'index']);
Route::resource('products', ProductController::class);
Route::resource('product-collections', ProductCollectionController::class);
Route::resource('categories', CategoryController::class);
Route::resource('categories.products', CategoryProductController::class)->only(['index']);
Route::resource('categories.children', CategoryChildrenController::class)->only(['index']);
Route::resource('orders', OrderController::class)->only(['store']);
