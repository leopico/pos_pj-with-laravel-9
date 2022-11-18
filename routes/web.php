<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\User\AjaxController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\UserController as Enter;


//login , register
Route::middleware(['admin_auth'])->group(function(){
    //admin
    Route::redirect('/', 'loginPage');
    Route::get('loginPage',[AuthController::class,'loginPage'])->name('auth#loginPage');
    Route::get('registerPage',[AuthController::class,'registerPage'])->name('auth#registerPage');
});


Route::middleware(['auth'])->group(function () {
    //dashboard
    Route::get('dashboard',[AuthController::class,'dashboard'])->name('dashboard');

    //admin
    //category
    Route::middleware('admin_auth')->group(function () {
    Route::prefix('category')->group(function () {
    Route::get('list',[CategoryController::class,'list'])->name('category#list');
    Route::get('createPage',[CategoryController::class,'createPage'])->name('category#createPage');
    Route::post('create',[CategoryController::class,'create'])->name('category#create');
    Route::get('delete/{id}',[CategoryController::class,'delete'])->name('category#delete');
    Route::get('edit/{id}',[CategoryController::class,'edit'])->name('category#edit');
    Route::post('update',[CategoryController::class,'update'])->name('category#update');
    });

    //admin account
    Route::prefix('admin')->group(function () {
        //password
        Route::get('password/changePage',[AdminController::class,'changePasswordPage'])->name('admin#changePasswordPage');
        Route::post('change/password',[AdminController::class,'changePassword'])->name('admin#changePassword');
        Route::get('details',[AdminController::class,'details'])->name('admin#details');
        Route::get('edit',[AdminController::class,'edit'])->name('admin#edit');
        Route::post('update/{id}',[AdminController::class,'update'])->name('admin#update');
        Route::get('list',[AdminController::class,'list'])->name('admin#list');
        Route::get('delete/{id}',[AdminController::class,'delete'])->name('admin#delete');
        Route::get('changeRole/{id}',[AdminController::class,'changeRole'])->name('admin#changeRole');
        Route::post('change/role/{id}',[AdminController::class,'change'])->name('admin#change');

});

        //products
        Route::prefix('products')->group(function () {
            Route::get('list',[ProductController::class,'list'])->name('product#list');
            Route::get('create',[ProductController::class,'createPage'])->name('product#createPage');
            Route::post('create',[ProductController::class,'create'])->name('product#create');
            Route::get('delete/{id}',[ProductController::class,'delete'])->name('product#delete');
            Route::get('edit/{id}',[ProductController::class,'edit'])->name('product#edit');
            Route::get('updatePage/{id}',[ProductController::class,'updatePage'])->name('product#updatePage');
            Route::post('update',[ProductController::class,'update'])->name('product#update');
        });

        //delivery
        Route::prefix('delivery')->group(function () {
            Route::get('list',[DeliveryController::class,'list'])->name('delivery#list');
            Route::get('create',[DeliveryController::class,'createPage'])->name('delivery#createPage');
            Route::post('create',[DeliveryController::class,'create'])->name('delivery#create');
            Route::get('delete/{id}',[DeliveryController::class,'delete'])->name('delivery#delete');
            Route::get('edit/{id}',[DeliveryController::class,'edit'])->name('delivery#edit');
            Route::post('update',[DeliveryController::class,'update'])->name('delivery#update');
        });

        //userList
        Route::prefix('user')->group(function () {
            Route::get('list',[Enter::class,'list'])->name('admin#userList');
            Route::get('change/role',[Enter::class,'changeUserRole'])->name('ajax#changeUserRole');
        });

        //order
        Route::prefix('order')->group(function () {
            Route::get('list',[OrderController::class,'list'])->name('order#list');
            Route::get('change/status',[OrderController::class,'changeStatus'])->name('order#changeStatus');
            Route::get('ajax/change/status',[OrderController::class,'ajaxChangeStatus'])->name('order#ajaxChangeStatus');
            Route::get('listInfo/{orderCode}',[OrderController::class,'listInfo'])->name('order#listInfo');
        });
});
    //user
    Route::prefix('user')->middleware('user_auth')->group(function () {
        //home
    Route::get('/homePage',[UserController::class,'home'])->name('user#home');
        //filter
    Route::get('/filter/{id}',[UserController::class,'filter'])->name('user#filter');
        //history
    Route::get('history',[UserController::class,'history'])->name('user#history');

        //pizza details
    Route::prefix('pizza')->group(function () {
        Route::get('details/{id}',[UserController::class,'pizzaDetails'])->name('user#pizzaDetails');
    });

    //cart list
    Route::prefix('cart')->group(function () {
        Route::get('cartList',[CartController::class,'cartList'])->name('user#cartList');
    });


        //password
    Route::prefix('password')->group(function () {
        Route::get('change',[UserController::class,'changePasswordPage'])->name('user#changePasswordPage');
        Route::post('change',[UserController::class,'changePassword'])->name('user#changePassword');
    });
        //account
    Route::prefix('account')->group(function () {
        Route::get('change',[UserController::class,'accountChangePage'])->name('user#accountChangePage');
        Route::post('change,{id}',[UserController::class,'accountChange'])->name('user#accountChange');
    });

    //ajax page for sorting in user
    Route::prefix('ajax')->group(function () {
        Route::get('pizza/list',[AjaxController::class,'pizzaList'])->name('ajax#pizzaList');
        Route::get('addToCart',[AjaxController::class,'addToCart'])->name('ajax#addToCart');
        // for delivery location
        Route::get('location',[AjaxController::class,'location'])->name('delivery#location');
        //order
        Route::get('order',[AjaxController::class,'order'])->name('ajax#order');
        //clear cart
        Route::get('clear/cart',[AjaxController::class,'clearCart'])->name('ajax#clearCart');
        //clear current product
        Route::get('clear/current/product',[AjaxController::class,'clearCurrentProduct'])->name('currentCurrentProduct');
        //increase view count
        Route::get('viewCount',[AjaxController::class,'viewCount'])->name('ajax#viewCount');
    });

});
});
