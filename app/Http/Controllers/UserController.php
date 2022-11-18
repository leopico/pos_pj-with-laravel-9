<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //direct user list page
    public function list(){
        $users = User::where('role','user')
        ->paginate(5);
        // dd($users->toArray());
        return view('admin.user.list',compact('users'));
    }
    //change user role
    public function changeUserRole(Request $request){
    // logger($request->all());
    User::where('id',$request->userId)->update([
        'role' => $request->role ,
    ]);
    }
}
