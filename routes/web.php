<?php
use App\Http\Controllers\productController;
use App\Http\Controllers\customerController;
use App\Http\Controllers\categoryController;
use App\Http\Controllers\cashierController;
use App\Http\Controllers\orderController;
use App\Http\Controllers\reportController;
use App\Http\Controllers\authController;
use App\Http\Middleware\Auth;
use App\Http\Middleware\CheckRole;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;

Route::get('/login',function(){
    return view('Auth.login');
});
Route::post('/login',[authController::class,'login']);

    // Middle Ware
Route::middleware([Auth::class])->group(function(){
Route::get('/settings',function(){
    return view('Layout.setting');
});
Route::get('/logout',[authController::class,'logout']);
Route::get('/',[productController::class,'index']);
Route::get('/products',[productController::class,'table']);



Route::post('/productCreate',[productController::class,'create']);
Route::post('/productUpdate',[productController::class,'update']);
Route::delete('/productDelete/{id}', [productController::class, 'destroy']);

Route::post('/categoryCreate',[categoryController::class,'create']);
Route::post('/categoryUpdate',[categoryController::class,'update']);
Route::post('/categoryDelete/{id}',[categoryController::class,'destroy']);


Route::post('/orders', [orderController::class, 'store'])->name('orders.store');
Route::get('/orders/latest/{customerId}', [OrderController::class, 'getLatestOrder']);
Route::post('/orders/save', [orderController::class, 'saveOrder']);
Route::post('/orders/{id}/paid',[orderController::class,'status']);
Route::post('/addNewOrder',[orderController::class,'addItemToOrderBulk'])->name('order.add.bulk');

Route::get('/orders',[orderController::class,'order']);
Route::get('/reports',[reportController::class,'report'])->middleware(CheckRole::class);

Route::get('/tables', [orderController::class, 'tableView'])->name('orders.tables');
Route::post('/customersCreate',[customerController::class,'create']);

Route::get('/cashiers',[cashierController::class,'index'])->middleware(CheckRole::class);
Route::post('/cashierCreate',[cashierController::class,'create']);
Route::post('/cashierUpdate',[cashierController::class,'update']);
Route::post('/cashierDelete/{id}',[cashierController::class,'delete']);

});

