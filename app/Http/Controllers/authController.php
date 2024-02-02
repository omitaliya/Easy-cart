<?php

namespace App\Http\Controllers;

use App\Mail\resetPasswordEmail;
use App\Models\User;
use App\Models\order;
use App\Models\order_items;
use Illuminate\Support\Str;
use App\Models\order_status;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Notifications\ResetPassword;

class authController extends Controller
{
    function login()
    {
        
        return view('home.account.login');
    }

    function logout()
    {
        Auth::logout();

        message('warning', 'You have been logged out');
        return redirect()->route('home');
    }

    function myprofile()
    {
        return view('home.account.myprofile');
    }

    function update_profile(Request $data)
    {
        $validator=Validator::make($data->all(),[
            'name'=>'required',
            'email'=>'required|email|unique:users,email,'.auth()->id().',id',
             'phone'=>'required|numeric|digits:10',
        ]);

        if($validator->passes())
        {

            $user=user::find(auth()->id());

            $user->update([
                'name'=>$data->name,
                'email'=>$data->email,
                'phone'=>$data->phone,
            ]);

            return response()->json([
                'status'=>true,
                'message'=>'Profile Updated!'

        ]);

        }else
    {
        return response()->json([
                'status'=>false,
                'errors'=>$validator->errors()

        ]);
    }
    }

    function storeChangedPassword(Request $data)
    {
        $validator=Validator::make($data->all(),[
            'old_password'=>'required',
            'new_password'=>'required|min:4|max:32',
            'confirm_password'=>'required|same:new_password',
        ]);

        if($validator->passes())
        {

            if(!Hash::check($data->old_password,Auth::user()->password))
            {
                $status=true;
                $RoW='W';
                $message='Old password is invalid!';
            }else
            {
                $user=user::find(auth()->id());
    
                $user->update([
                    'password'=>bcrypt($data->new_password)
                ]);

                $status=true;
                $message='Password Updated!';
                $RoW='R';

            }

            return response()->json([
                'status'=>$status,
                'message'=>$message,
                'RoW'=>$RoW

        ]);

        }else
            {
                return response()->json([
                        'status'=>false,
                        'errors'=>$validator->errors()

                ]);
            }
}

    function myorder()
    {
        $order=order::where('user_id',Auth::id())->latest()->get();
        return view('home.account.myorder',compact('order'));
    }

    function orderDetail($id)
    {
        $order=order::with('discount')->find($id);
        $os=order_status::where('order_id',$id)->latest()->first();
        $order_items=order_items::with('order','product')->where('order_id',$id)->get();
        $count=order_items::where('order_id',$id)->count();

        return view('home.account.orderDetail',compact('os','order','order_items','count'));
    }

    function changePassword()
    {
        return view('home.account.changePassword');
    }



    function loginUser(Request $data)
    {
        $validator=Validator::make($data->all(),[
            'email' => 'required|email|exists:users',
            'password' => 'required'
        ],[
            'email.exists'=>'No account found from given email!'
        ]);

        if($validator->passes())
        {
            if(Auth::attempt(['email'=>$data->email,'password'=>$data->password]))
            {
               

                message('success','You are Logged In');
                return response()->json([
                    'status'=>'success',
                ]);
            }
            else
            {
                return response()->json([
                    'status'=>'invalid',
                    'message'=>'Password Invalid'
                ]);
            }
        }else
        {
            return response()->json([
                'status'=>'error',
                'errors'=>$validator->errors()
            ]);
        }
    }

    function registration()
    {
        return view('home.account.register');
    }

    function registerData(Request $req){
        $validated=Validator::make($req->all(),[
            'name'=>'required|string',
            'phone'=>'required|numeric|digits:10',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|min:4',
            'cpassword'=>'required|same:password'
        ],[
            'cpassword.required'=>'The Confirm Password field is required.',
            'cpassword.same'=>'The Confirm Password should match with password.'
        ]);

        if($validated->passes())
        {
            $data=$validated->validated();
            User::create($data);

            message('success','Registration Successful!');
            return response()->json([
                'status'=>true,
            ]);
        }else
        {
        return response()->json([
                'status'=>false,
                'errors'=>$validated->errors()
            ]);
    }
}
}
