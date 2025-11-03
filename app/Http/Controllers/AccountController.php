<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    //
    public function registration()
    {
        return view("front.account.registration");
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'=>'required',
            'email'=> 'required|email',
            'password'=> 'required|min:5|same:confirm_password',
            'confirm_password'=>'required'
        ]);
        if( $validator->passes())
        {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make( $request->password );
            $user->save();
            session()->flash('success','Đăng kí thành công');
            return response()->json([
                'status'=>true,
                'errors'=>[]
            ]);
        } 
        else
        {
            return response()->json([
                'status'=>false,
                'errors'=>$validator->errors()
            ]);
        }       
    }
    public function login()
    {
        return view("front.account.login");
    }
}
