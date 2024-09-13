<?php

use App\Http\Controllers\CartItemsController;
use App\Http\Controllers\CartsController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderItemsController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\RegisterUserController;
use App\Http\Controllers\SessionUserController;
use App\Http\Controllers\VerifyUserController;
use App\Http\Controllers\WorkersController;
use App\Models\CartItems;
use App\Models\Carts;
use App\Models\Workers;
use Illuminate\Support\Facades\Route;
use Twilio\Rest\Api\V2010\Account\Call\PaymentContext;
use Twilio\Rest\Proxy\V1\Service\SessionContext;

Route::get('/register',[RegisterUserController::class,'create'])->name('register');
Route::get('/',[SessionUserController::class,'create'])->name('login');
//workers
Route::get('/register-worker',[WorkersController::class,'create'])->name('register.worker');
Route::get('/login-worker',[WorkersController::class,'login'])->name('login.worker');
Route::post('/register-worker',[WorkersController::class,'store'])->name('worker.signup');
Route::post('/login-worker',[WorkersController::class,'verify']);


Route::post('register',[RegisterUserController::class,'store']);

Route::post('login',[SessionUserController::class,'store']);

Route::middleware('worker')->group(function(){
    Route::get('/dashboard',[DashboardController::class,'index']);
    Route::post('/dasboard',[DashboardController::class,'store']);
});

Route::middleware('auth')->group(function(){
    Route::get('/verify-sms',[VerifyUserController::class,'index'])->name('sms.verifyform');
    Route::post('/verify-sms',[VerifyUserController::class,'verifyotp'])->name('verifysms.code');

Route::get('/dashboard',[DashboardController::class,'index']);
Route::post('/dasboard',[DashboardController::class,'store']);

Route::get('/logout',[SessionUserController::class,'destroy']);
//user
Route::get('/user/{user}',[SessionUserController::class,'show']);
Route::patch('/user/{user}',[SessionUserController::class,'update']);
Route::patch('/user-password/{user}',[SessionUserController::class,'updatePassword']);
//categories
Route::get('/categories',[CategoriesController::class,'index']);
Route::get('/categories/{categories}',[CategoriesController::class,'show']);
Route::patch('/categories/{categories}',[CategoriesController::class,'update']);
Route::delete('/categories/{categories}',[CategoriesController::class,'destroy']);
Route::get('/categories-add',[CategoriesController::class,'create']);
Route::post('/categories-add',[CategoriesController::class,'store']);
Route::get('/searchcategories',[CategoriesController::class,'search']);


//products
Route::get('/products',[ProductsController::class,'index']);
Route::get('/products/{products}',[ProductsController::class,'show']);
Route::get('/searchproducts',[ProductsController::class,'search']);
Route::patch('/products/{products}',[ProductsController::class,'update']);
Route::delete('/products/{products}',[ProductsController::class,'destroy']);
Route::get('/products-add',[ProductsController::class,'create']);
Route::post('/products-add',[ProductsController::class,'store']);

//orders
Route::get('/orders-add',[OrdersController::class,'create']);
Route::get('/orders/{orders}',[OrdersController::class,'show']);
Route::get('/orders-add/{user}',[OrdersController::class,'processCartItems'])->name('orders.processcart');
Route::post('/orders',[OrdersController::class,'store']);
Route::delete('/orders/{orders}',[OrdersController::class,'destroy'])->name('orders.delete');
Route::patch('/orders/{orders}',[OrdersController::class,'update'])->name('orders.update');
Route::get('/orders',[OrdersController::class,'index'])->name('orders.index');
Route::get('/order/success',[OrdersController::class,'success'])->name('order.success');
Route::get('/order/cancel',[OrdersController::class,'cancel'])->name('order.cancel');


//orderitems
Route::get('/orderitems-add',[OrderItemsController::class,'create']);

//carts
Route::get('/add-carts',[CartsController::class,'index']);
Route::post('/add-carts',[CartsController::class,'store'])->name('carts.add-cart');
Route::get('/searchcartproducts',[CartsController::class,'search']);
Route::delete('/carts/{carts}',[CartsController::class,'destroy']);

//dasboard

//cartitems
Route::get('/cartitems/{cartid}',[CartItemsController::class,'viewCartItems'])->name('cartitems.view');
Route::get('/cartitems/item/{cartItems}',[CartItemsController::class,'show'])->name('cartitems.show');
Route::delete('/cartitems/item/{cartItems}',[CartItemsController::class,'destroy']);
Route::get('/searchcartitems/{cartid}',[CartItemsController::class,'search']);
Route::patch('/cartitems/item/{cartItems}',[CartItemsController::class,'update']);

//payment
Route::get('/payments/{orderid}',[PaymentsController::class,'checkout']);
Route::get('/payments',[PaymentsController::class,'index']);
Route::get('/payments-receipt/{orderid}',[PaymentsController::class,'printReceipt']);
Route::get('/payments-receipt/print/{orderid}',[PaymentsController::class,'printPage'])->name('receipt.print');


});
Route::post('/webhook',[PaymentsController::class,'webhook'])->name('payment.webhook');
