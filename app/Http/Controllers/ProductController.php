<?php

namespace App\Http\Controllers;

use Storage;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    //product list
    public function list(){
        $pizzas = Product::select('products.*','categories.name as category_name')
            ->when(request('key'),function($query){
            $query->where('products.name','like','%'.request('key').'%');
        })
        ->leftjoin('categories','products.category_id','categories.id')
        ->orderBy('products.created_at','desc')->paginate(5);
        return view('admin.products.pizzaList',compact('pizzas'));
    }

    //direct pizza create page
    public function createPage(){
        $categories = Category::select('id','name')->get(); //take data form categories table
        // dd($categories->toArray());
        return view('admin.products.create',compact('categories'));
    }

    //create product
    public function create(Request $request){
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

    //update Page
    public function updatePage($id){
        $pizza = Product::where('id',$id)->first();
        $category = Category::get();
        return view('admin.products.update',compact('pizza','category'));
    }

    //update pizza
    public function update(Request $request){
        $this-> productValidationCheck($request,'update');
        // dd('success');
        $data  = $this->requestProductInfo($request);

        if($request->hasFile('pizzaImage')){
            $oldImageName = Product::where('id',$request->pizzaId)->first();
            $oldImageName = $oldImageName->image;
            if($oldImageName != null){
                Storage::delete('public/'.$oldImageName);
            }
            $fileName = uniqid().$request->file('pizzaImage')->getClientOriginalName(); //get new image
            $request->file('pizzaImage')->storeAs('public',$fileName); //store img
            $data['image'] = $fileName; //store img name in DB
        }

        Product::where('id',$request->pizzaId)->update($data); //update new data in DB and UI
        return redirect()->route('product#list')->with(['updateSuccess'=>'Product update Successed...']);
    }

    //delete product
    public function delete($id,Request $request){
        $oldImage = Product::where('id',$id)->first();
        $oldImage = $oldImage->image;
        if($oldImage != null){
            Storage::delete('public/'.$oldImage);
        }
        Product::where('id',$id)->delete();
        return redirect()->route('product#list')->with(['deleteSuccess'=>'Product delete Successed...']);
    }

    //edit product
    public function edit($id){
        $pizza = Product::select('products.*','categories.name as category_name')
        ->leftjoin('categories','products.category_id','categories.id')
        ->where('products.id',$id)->first();
        return view('admin.products.edit',compact('pizza'));
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
}
