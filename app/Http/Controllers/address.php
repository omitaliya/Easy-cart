<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\address as add;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class address extends Controller
{
    function save(Request $data)
    {
        $validator=Validator::make($data->all(),[
            'fname'=>'required|alpha',
            'lname'=>'required|alpha',
            'email'=>'required|email',
            'description'=>'required',
            'city'=>'required|alpha',
            'state'=>'required|alpha',
            'country'=>'required|alpha',
            'pincode'=>'required|numeric|digits:6',
            'mobile'=>'required|numeric|digits:10',
            'note'=>'nullable',
        ]);

        if($validator->passes())
        {
            $validatedData=$validator->validated();
            $validatedData['user_id']=Auth::id();

            $conditions = ['user_id' => Auth::id()]; 
            $save=add::updateOrCreate($conditions,$validatedData);

            message('success','Saved successfully');
            return response()->json([
                'status' => true
            ]);
        }else
        {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
}
