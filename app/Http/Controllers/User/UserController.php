<?php

namespace App\Http\Controllers\User;

use Storage;
use Carbon\Carbon;
use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\Delivery;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //user home page
    public function home(){
        $pizza = Product::orderBy('created_at','desc')->get();
        $category = Category::get();
        $cart = Cart::where('user_id',Auth::user()->id)->get();
        $history = Order::where('user_id',Auth::user()->id)->get();
        // dd($cart);
        return view('user.main.home', compact('pizza','category','cart','history'));
    }
    //change password page
    public function changePasswordPage(){
        return view('user.password.change');
    }
    //change password
    public function changePassword(Request $request){
        $this->passwordValidationCheck($request);
        $currentUserId = Auth::user()->id;
        $dbhashValue = User::select('password')->where('id',$currentUserId)->first();
        $dbPassword = $dbhashValue->password;


        if(Hash::check($request->oldPassword, $dbPassword)){
            $data = [
                'password' => Hash::make($request->newPassword)
            ];
            User::where('id',Auth::user()->id)->update($data);

            return back()->with(['changeSuccess'=>'Password change successed...']);
        }else{
            return back()->with(['notMatch' => 'The old password not match. Try Again!']);
        }
    }

    //user account change page
    public function accountChangePage(){
        return view('user.profile.account');
    }

    //categories filter
    public function filter($categoryId){
        // dd($categoryId);
        $pizza = Product::where('category_id',$categoryId)->orderBy('created_at','desc')->get();
        $category = Category::get();
        $cart = Cart::where('user_id',Auth::user()->id)->get();
        $history = Order::where('user_id',Auth::user()->id)->get();
        return view('user.main.home', compact('pizza','category','cart','history'));
    }

    //direct pizza details
    public function pizzaDetails($pizzaId){
        $pizza = Product::where('id',$pizzaId)->first();
        $pizzaList = Product::get();
        return view('user.main.details',compact('pizza','pizzaList'));
    }



    //user account change
    public function accountChange($id,Request $request){
        $this->accountValidationCheck($request);
        $data = $this->getUserData($request);

        //for image
        if($request->hasFile('image')){
            // 1. old image name has? | check =>delete | store
            $dbImage = User::where('id',$id)->first();
            $dbImage = $dbImage->image;

            if($dbImage != null){
                Storage::delete('public/'.$dbImage);
            }

           $fileName = uniqid() . $request->file('image')->getClientOriginalName();
           $request->file('image')->storeAs('public',$fileName); //store to pj
           $data['image'] = $fileName;
        }
        User::where('id',$id)->update($data);
        return back()->with(['updateSuccess'=>'Customer account updated']);
    }
    //direct history page
    public function history(){
        $order = Order::when(request('key'),function($query){
            $query->where('order_code','like','%'.request('key').'%');
        })
        ->where('user_id',Auth::user()->id)->orderBy('created_at','desc')->paginate(10);
        // dd($order->toArray());
        return view('user.main.history',compact('order'));
    }


    //getUserData for update
    private function getUserData($request){
        return [
            'name' => $request->name,
            'email' => $request->email,
            'gender' => $request->gender,
            'phone' => $request->phone,
            'address' => $request->address,
            'updated_at' => Carbon::now(),
        ];
    }

    //update validation check
    private function accountValidationCheck($request){
        Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required',
            'gender' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'image' => 'mimes:png,jpg,jpeg.jfif,webp'
        ])->validate();
    }

    //password validation check
    private function passwordValidationCheck($request){
       Validator::make($request->all(),[
        'oldPassword' => 'required | min:6 | max:10 ',
        'newPassword' => 'required | min:6 | max:10 ',
        'confirmPassword' => 'required | min:6 | max:10 | same:newPassword',
       ])->validate();
    }
}
