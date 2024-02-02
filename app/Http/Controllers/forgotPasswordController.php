<?php

namespace App\Http\Controllers;

use App\Mail\resetPasswordEmail;
use App\models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class forgotPasswordController extends Controller
{
    function forgotPasswordForm()
    {
        return view('home.account.forgotPasswordForm');
    }

    function forgotPassword(Request $data)
    {
        $findmail=user::where('email',$data->email)->first();

        if($findmail==null)
        {
            return response()->json([
                'status'=>false,
                'message'=>'Wrong E-mail!'
            ]);
        }

        $token=Str::random(33);

        $delete=DB::table('password_reset_tokens')->where('email',$data->email)->delete();

       $insert_token= DB::table('password_reset_tokens')->insert([
            'email' => $data->email,
            'token' => $token,
            'created_at'=>now()
        ]);

        $mailData=[
            'token' => $token,
        ];

        Mail::to($data->email)->send(new resetPasswordEmail($mailData));

        message('info','Check your Mail-Box!');

        return response()->json([
            'status'=>true,
        ]);
    }

    function resetPasswordForm ($token)
    {
        $check_token=DB::table('password_reset_tokens')->where('token',$token)->first();

        if($check_token==null)
            {
              return redirect()->route('forgotPasswordForm');   
            }
        return view('home.account.resetPasswordForm',[
            'token'=>$token
        ]);
    }


    function resetPassword(Request $data)
    {
        $validator=Validator::make($data->all(),[
            'new_password'=>'required|min:4|max:32',
            'confirm_password'=>'required|same:new_password',
        ]);

        if($validator->passes())
        {

            $check_token=DB::table('password_reset_tokens')->where('token',$data->token)->first();

        if($check_token==null)
            {
              return redirect()->route('forgotPasswordForm');   
            }

            $user=user::where('email',$check_token->email)->first();

            $user->update([
                'password'=>Hash::make($data->new_password)
            ]);

            message('success','Password updated successfully!');

            return response()->json([
                'status'=>true,
        ]);
    

        }else{
                return response()->json([
                        'status'=>false,
                        'errors'=>$validator->errors()

                ]);
            }
    }
}
