<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

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
    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "email"=> "required|email",
            "password"=>'required'
        ]);
        if( $validator->passes())
        {
            if(Auth::attempt(['email'=>$request->email,'password'=>$request->password]))
            {
                return redirect()->route('account.profile');
            } 
            else
            {
                return redirect()->route('account.login')->with('error','Email/Pass ko hợp lệ');
            }       
        } 
        else
        {
            return redirect()
                 ->route('account.login')
                 ->withErrors($validator)
                 ->withInput($request->only('email'));
        }   
    }
    public function profile()
    {
        $id = Auth::user()->id;
        $user = User::where('id',$id)->first();
        return view('front.account.profile',
    ['user'=>$user]);
    }
    public function updateProfile(Request $request)
    {
        $id = Auth::user()->id;
        $validator = Validator::make($request->all(), [
            'name'=>'required|min:5|max:20',
            'email'=> 'required|email|unique:users,email,'.$id.'id',
        ]);
        if( $validator->passes())
        {
            $user = User::find($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->designation = $request->designation;
            $user->mobile = $request->mobile;
            $user->save();
            session()->flash('success','Cập nhật hồ sơ thành công');

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
    public function updateProfilePic(Request $request)
    {
        $id = Auth::user()->id;
        $validator = Validator::make($request->all(), [
            'image'=>'required',
        ]);
        if( $validator->passes() )
        {
            $image = $request->image;
            $ext =$image->getClientOriginalExtension();
            $imageName = $id.'-'.time().'.'.$ext;
            $image->move(public_path('/profile_pic/'), $imageName);
            //tạo ảnh nhỏ
            $sourcePath = public_path('/profile_pic/'.$imageName);

            // alternatively create new manager instance by class name and default configuration
            $manager = new ImageManager(Driver::class);
            $image = $manager->read($sourcePath);
            $image->cover(150,150);
            $image->toPng()->save(public_path('/profile_pic/'.$imageName));
            User::where('id', $id)->update(['image'=>$imageName] );
            File::delete(public_path('/profile_pic/'.Auth::user()->image));
            session()->flash('success','Cập nhật ảnh hồ sơ thành công');
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
    public function logout()
    {
        Auth::logout();
        return redirect()->route('account.login');
    }
    
}
