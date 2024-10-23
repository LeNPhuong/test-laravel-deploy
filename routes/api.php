<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VoucherController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::group([
    'middleware' => 'api',
    'prefix' => 'auth',
], function ($router) {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');
    Route::post('/refresh', [AuthController::class, 'refresh'])->middleware('auth:api');
    Route::post('/profile', [AuthController::class, 'profile'])->middleware('auth:api');

    //Thông tin tài khoản
    Route::get('/{id}', [UserController::class, 'show'])->middleware('auth:api'); // Lấy thông tin người dùng theo id
    Route::put('/{id}', [UserController::class, 'update'])->middleware('auth:api'); // Cập nhật thông tin người dùng
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'products',
], function ($router) {

    Route::get('/', [ProductController::class, 'index']);
    Route::get('/{id}', [ProductController::class, 'show']);
    Route::post('/{productId}/comment', [CommentController::class, 'store'])->middleware('auth:api');
});
Route::post('comments/{commentId}/toggleLike', [CommentController::class, 'toggleLike'])->middleware('auth:api');
Route::get('comments/{productId}', [CommentController::class, 'show']);


Route::group([
    'middleware' => 'api',
    'prefix' => 'categories',
], function ($router) {

    Route::get('/', [CategoriesController::class, 'index']);
});

Route::post('/checkout', [OrderController::class, 'checkout'])->middleware('auth:api');
//Đơn hàng
Route::get('/orders/{id}', [OrderController::class, 'getOrderDetails'])->middleware('auth:api');
Route::get('/get-orders', [OrderController::class, 'getOrders'])->middleware('auth:api');
Route::get('/vouchers', [VoucherController::class, 'getVoucher']);


//Demo phân quyền
// Route::middleware(['auth:api', 'admin'])->group(function () {
//     Route::get('/admin/dashboard', function() {
//         die('123');
//     });
// });


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
