<?php

namespace App\Http\Controllers;

use Storage;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;



class AdminController extends Controller
{
    //change password page
    public function changePasswordPage(){
        return view("admin.account.changePassword");
    }

    //change password
    public function changePassword(Request $request){
        // dd($request->all());
        /*
        1. all field must be fill
        2. new password & confirm password length must be greater than 6
        3. new password and confirm password must be same
        4. client old password must be same with db old password
        */

        $this->passwordValidationCheck($request);
        $currentUserId = Auth::user()->id;
        $dbhashValue = User::select('password')->where('id',$currentUserId)->first();
        // dd($dbhashValue->toArray()); //testing output
        $dbPassword = $dbhashValue->password;
        // dd($dbPassword); //testing output

        if(Hash::check($request->oldPassword, $dbPassword)){
            $data = [
                'password' => Hash::make($request->newPassword)
            ];
            User::where('id',Auth::user()->id)->update($data);
            // Auth::logout();
            // return redirect()->route('category#list');
            return back()->with(['changeSuccess'=>'Password change successed...']);
        }else{
            return back()->with(['notMatch' => 'The old password not match. Try Again!']);
        }
        // $hashValue = Hash::make('sithu');
        // if(Hash::check('sithu', $hashValue)){
        //     dd('password same');
        // }else{
        //     dd('password not same');
        // }

    }

    //details
    public function details(){
        return view('admin.account.details');
    }

    //edit
    public function edit(){
        return view('admin.account.edit');
    }

    //update
    public function update($id,Request $request){
        // dd($id,$request->all());
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
        return redirect()->route('admin#details')->with(['updateSuccess'=>'Admin account updated']);
    }

    //admin list
    public function list(){
        $admin = User::when(request('key'),function($query){
            $query->orwhere('name','like','%'.request('key').'%')
            ->orwhere('email','like','%'.request('key').'%')
            ->orwhere('gender','like','%'.request('key').'%')
            ->orwhere('phone','like','%'.request('key').'%')
            ->orwhere('address','like','%'.request('key').'%');
        })
        ->where('role','admin')->paginate(5);
        return view('admin.account.list',compact('admin'));
    }

    //admin delete
    public function delete($id){
        User::where('id',$id)->delete();
        return back()->with(['deleteSuccess' => 'Admin account deleted...']);

    }

    //admin changeRole
    public function changeRole($id){
        $account = User::where('id',$id)->first();
        return view('admin.account.changeRole',compact('account'));
    }

    //admin change
    public function change($id,Request $request){
        $data = $this->requestUserData($request);
        User::where('id',$id)->update($data);
        return redirect()->route('admin#list');
    }

    //request user data
    private function requestUserData($request){
        return [
            'role' => $request->role,
        ];
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
            'image' => 'mimes:png,jpg,jpeg'
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
