<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DeliveryController extends Controller
{
    //delivery list page
    public function list(){
        // dd(request('key'));
        $deliveries = Delivery::when(request('key'),function($query){//for data searching
            $query->where('deli_way','like','%'.request('key').'%');
        })->orderBy('created_at','desc')->paginate(5);
        return view('admin.delivery.deliveryList',compact('deliveries'));
    }

    //direct create page
    public function createPage(){
        return view('admin.delivery.create');
    }

    //create delivery
    public function create(Request $request){
        $this->deliverytValidationCheck($request,'create');
        $data = $this->requestDeliveryInfo($request);
        Delivery::create($data);
        return redirect()->route('delivery#list');
    }
    //edit page
    public function edit($id){
        $deliEdit = Delivery::where('id',$id)->first();
        // dd($deliEdit->toArray());
        return view('admin.delivery.edit',compact('deliEdit'));
    }

    //update page
    public function update(Request $request){
        // dd($request->all()); test output data
        $this->deliverytValidationCheck($request,'update');
        $data = $this->requestDeliveryInfo($request); //to array format
        Delivery::where('id',$request->deliveryId)->update($data);
        return redirect()->route('delivery#list');
    }

    //delete delivery
    public function delete($id){
        Delivery::where('id',$id)->delete(); //id from model
        return back()->with(['deleteSuccess' => 'Route deleted...']);
    }

    // request product info
    private function requestDeliveryInfo($request){
        return [
            'deli_way' => $request->deliveryWay,
            'deli_fee' => $request->deliveryFee,
        ];
    }

    private function deliverytValidationCheck($request,$action){
        $validationRules = [
            // 'deliveryWay' => 'required | unique:deliveries,deli_way,'.$request->deliveryId,
            'deliveryFee' => 'required'

        ];
        $validationRules['deliveryWay'] = $action == 'create' ? 'required' : 'required | unique:deliveries,deli_way,'.$request->deliveryId;
        // dd($validationRules);
        Validator::make($request->all(),$validationRules)->validate();
    }

}
