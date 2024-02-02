<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class settingController extends Controller
{
     function changePasswordForm()
        {
              return view('admin.change-password');
        }

        function saveChangedPassword(Request $data)
        {
            $validator=Validator::make($data->all(),[
                'old_password'=>'required',
                'new_password'=>'required|min:4|max:32',
                'confirm_password'=>'required|same:new_password',
            ]);
    
            if($validator->passes())
            {
    
                if(!Hash::check($data->old_password,Auth::guard('admin')->user()->password))
                {
                    $status=true;
                    $RoW='W';
                    $message='Old password is invalid!';
                }else
                {
                    $user=user::find(Auth::guard('admin')->id());
        
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
}
