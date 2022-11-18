<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Category;
use App\Models\Delivery;
use App\Models\OrderList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    //products list
    public function productList(){
        $products = Product::orderBy('create_at','desc')->get();
        return response()->json($products, 200);
    }

    //categories list
    public function categoryList(){
        $categories = Category::orderBy('create_at','desc')->get();
        return response()->json($categories, 200);
    }

    //carts list
    public function cartList(){
        $carts = Cart::orderBy('create_at','desc')->get();
        return response()->json($carts, 200);
    }

    //contacts list
    public function contactList(){
        $contacts = Contact::orderBy('create_at','desc')->get();
        return response()->json($contacts, 200);
    }

    //deliveries list
    public function deliveryList(){
        $deliveries = Delivery::orderBy('create_at','desc')->get();
        return response()->json($deliveries, 200);
    }

    //orders list page
    public function orderListPage(){
        $orders = Order::orderBy('create_at','desc')->get();
        return response()->json($orders, 200);
    }

    //orders list
    public function orderList(){
        $orderList = OrderList::orderBy('create_at','desc')->get();
        return response()->json($orderList, 200);
    }

    //users list
    public function userList(){
        $users = User::orderBy('create_at','desc')->get();
        return response()->json($users, 200);
    }


    //categories create
    public function categoryCreate(Request $request){
        // dd($request->all());
        $data = [
            'name' => $request->name,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];

        $response = Category::create($data);

        return response()->json($response, 200);

    }

    //create product
    public function productCreate(Request $request){
        // dd($request->all());
        $this->productValidationCheck($request,'create');
        // dd('success');
        $data = $this->requestProductInfo($request);

            $fileName = uniqid().$request->file('pizzaImage')->getClientOriginalName();
            $request->file('pizzaImage')->storeAs('public',$fileName);
            $data['image'] = $fileName;

        Product::create($data);
        return redirect()->route('product#list');

    }

    //create contact
    public function contactCreate(Request $request){
        // dd($request->all());
        $data = $this->getContactData($request);
        Contact::create($data);
        $contact = Contact::get();
        return response()->json($contact, 200);
    }

    //create delivery
    public function deliveryCreate(Request $request){
        // dd($request->all());
        $this->deliverytValidationCheck($request,'create');
        $data = $this->requestDeliveryInfo($request);
        Delivery::create($data);
        return response()->json($data, 200);
    }


    //get contact data
    private function getContactData($request){
        return [
          'name' => $request->name ,
          'email' => $request->email ,
          'message' => $request->message ,
          'created_at' => Carbon::now() ,
          'update_at' => Carbon::now()
        ];
    }

    //delete category
    public function categoryDelete(Request $request){
        // return $request->all();
        $data = Category::where('id',$request->id)->first();
        // dd($data->toArray());
        if(isset($data)){
            Category::where('id',$request->category_id)->delete();
            return response()->json(['status' => 'true'], 200);
        };
        return response()->json(['status' => 'fault','message' => 'There is no categories'], 500);
    }

    //delete product
    public function productDelete($id){
        // return $id;
        $oldImage = Product::where('id',$id)->first();
        if(isset($oldImage)){
        $oldImage = $oldImage->image;
        if($oldImage != null){
            Storage::delete('public/'.$oldImage);
        }
        Product::where('id',$id)->delete();
        return response()->json(['message' => 'deleted'], 200);
        }
        return response()->json(['status' => 'There is no products here'], 500);
    }

    //delete delivery
    public function deliveryDelete($id){
        // return $id;
        $data = Delivery::where('id',$id)->first();
        // dd($data->toArray());
        if(isset($data)){
            Delivery::where('id',$id)->delete();
            return response()->json(['message' => 'deleted'], 200);
        };
        return response()->json(['status' => 'failed','message' => 'There is no route'], 500);
    }

    //details category
    public function categoryDetails(Request $request){
        // return $request->all();
        $data = Category::where('id',$request->category_id)->first();
        // dd($data->toArray());
        if(isset($data)){
            return response()->json(['status' => 'true', 'category' => $data ], 200);
        };
        return response()->json(['status' => 'fault','message' => 'There is no categories'], 500);
    }


    //update category
    public function categoryUpdate(Request $request){
        // return $request->all();
        $dbSource = Category::where('id',$request->categoryId)->first();
        // return $dbSource;
        if(isset($dbSource)){
            $data = $this->requestCategoryData($request); //to array format
            // return $data;
            $response = Category::where('id',$request->categoryId)->update($data);
            return response()->json(['status' => true , 'message' => 'category update successed'], 200);
        }
        return response()->json(['status' => 'false' , 'message' => 'There is no categories for update'], 500);
    }


    // request product info
    private function requestProductInfo($request){

        return [
            'category_id' => $request->pizzaCategory,
            'name' => $request->pizzaName,
            'description' => $request->pizzaDescription,
            'price' => $request->pizzaPrice,
            'waiting_time' => $request->pizzaWaitingTime,
        ];
    }

    private function productValidationCheck($request,$action){
        $validationRules = [
            'pizzaName' => 'required | min:5 | unique:products,name,' .$request->pizzaId, //can update ifself
            'pizzaCategory' => 'required',
            'pizzaDescription' => 'required | min:10',
            'pizzaPrice' => 'required',
            'pizzaWaitingTime' => 'required'
        ];
        $validationRules['pizzaImage'] = $action == 'create' ? 'required | mimes:jpg,png,jpeg,webp,jfif | file' : 'mimes:jpg,png,jpeg,webp,jfif';
        // dd($validationRules);
        Validator::make($request->all(),$validationRules)->validate();
    }

    // request product info
    private function requestDeliveryInfo($request){
        return [
            'deli_way' => $request->deliveryWay,
            'deli_fee' => $request->deliveryFee,
        ];
    }

    //get deliver for validation
    private function deliverytValidationCheck($request,$action){
        $validationRules = [
            'deliveryFee' => 'required'

        ];
        $validationRules['deliveryWay'] = $action == 'create' ? 'required' : 'required | unique:deliveries,deli_way,'.$request->deliveryId;
        // dd($validationRules);
        Validator::make($request->all(),$validationRules)->validate();
    }

    // request category data
    private function requestCategoryData($request){
        return [
            'name' => $request -> categoryName ,
            'updated_at' => Carbon::now() ,
        ];
    }


}
