<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\Delivery;
use App\Models\OrderList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AjaxController extends Controller
{
    //return pizza list
    public function pizzaList(Request $request){
        // logger($request->all());
        if($request->status == 'asc'){
            $data = Product::orderBy('created_at','asc')->get();
        }else {
            $data = Product::orderBy('created_at','desc')->get();
        }
        return $data;
    }

    // return add to  cart
    public function addToCart(Request $request){
        // logger($request->all());
        $data = $this->getOrderData($request);
        // logger($data);
        Cart::create($data);
        $response =  [
            'message' => 'Add To Cart Complete' ,
            'status' => 'success',
        ];
        return response()->json($response, 200);
   }

// ajax for delivery location
   public function location(Request $request){
        $data = Delivery::select('deli_fee')->where('id',$request->id)->get();
        // logger($data->toArray());
        return response()->json($data, 200);
   }

//ajax for order
   public function order(Request $request){
    // logger($request->all());
    $total = 0;
    foreach($request->all() as $item){
        // logger($item);
       $data = OrderList::create([
           'user_id' => $item['userId'],
           'product_id' => $item['productId'],
           'qty' => $item['qty'],
           'total' => $item['total'],
           'order_code' => $item['order_code'],
        ]);
        $total += $data->total;
        // logger($total);
    }
    Cart::where('user_id',Auth::user()->id)->delete();
    // logger($data->order_code);
    Order::create([
        'user_id' => Auth::user()->id ,
        'order_code' => $data->order_code ,
        'total_price' => $total,
    ]);

    return response()->json([
        'status' => 'true' ,
        'message' => 'order completed'
    ],200);
   }

   //clear cart
   public function clearCart(){
    Cart::where('user_id',Auth::user()->id)->delete();
   }

   //clear current product
   public function clearCurrentProduct(Request $request){
    // logger($request->all());
    Cart::where('user_id',Auth::user()->id)->where('product_id',$request->productId)->where('id',$request->orderId)->delete();
   }

   //ajax view count
   public function viewCount(Request $request){
    // logger($request->all());
    $products = Product::where('id',$request->productId)->first();

    $viewCount = [
        'view_count' => $products->view_count + 1
    ];
    $count = Product::where('id',$request->productId)->update($viewCount);
   }


    //private getOrderData
    private function getOrderData($request){
        return [
            'user_id' => $request->userId ,
            'product_id' =>$request->pizzaId ,
            'qty' => $request->count ,
            'created_at' => Carbon::now() ,
            'updated_at' => Carbon::now() ,
        ];
    }

}
