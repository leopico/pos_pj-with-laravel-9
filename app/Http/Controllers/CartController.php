<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Delivery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    //cart list page
    public function cartList(){
        $cartList = Cart::select('carts.*','products.name as pizza_name','products.price as pizza_price','products.image as product_img')
        ->leftjoin('products','products.id','carts.product_id')
        ->where('user_id',Auth::user()->id)->get();
        $totalPrice = 0;
        foreach($cartList as $c){
            $totalPrice += $c->pizza_price * $c->qty;
        }
        // dd($totalPrice);
        // dd($cartList->toArray());
        $delivery = Delivery::get();
        // dd($delivery->toArray());
        return view('user.main.cart',compact('cartList','totalPrice','delivery'));
    }
}
