<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ApiController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//This is for list with get method
Route::get('products/list',[ApiController::class,'productList']);
Route::get('carogories/list',[ApiController::class,'categoryList']);
Route::get('carts/list',[ApiController::class,'cartList']);
Route::get('contacts/list',[ApiController::class,'contactList']);
Route::get('deliveries/list',[ApiController::class,'deliveryList']);
Route::get('orders/list',[ApiController::class,'orderListPage']);
Route::get('orderList/list',[ApiController::class,'orderList']);
Route::get('users/list',[ApiController::class,'userList']);


//This is for create with post method
Route::post('categories/create',[ApiController::class,'categoryCreate']);
Route::post('products/create',[ApiController::class,'productCreate']);
Route::post('contacts/create',[ApiController::class,'contactCreate']);
Route::post('deliveries/create',[ApiController::class,'deliveryCreate']);

//This is for delete
Route::post('categories/delete',[ApiController::class,'categoryDelete']);
Route::get('products/delete/{id}',[ApiController::class,'productDelete']);
Route::get('deliveries/delete/{id}',[ApiController::class,'deliveryDelete']);


//This is details
Route::post('category/details',[ApiController::class,'categoryDetails']);


//This is for edit
Route::post('category/update',[ApiController::class,'categoryUpdate']);
