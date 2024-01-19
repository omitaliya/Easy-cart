<?php

namespace App\Http\Controllers\admin;

use App\Models\discount;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class discountController extends Controller
{
    function index(Request $r)
    {
        $discount=discount::latest();
        if($r->get('keyword')!=null)
        {
            $discount=$discount->where('code','like','%'.$r->keyword.'%');
        }
        $discount=$discount->paginate(10);

        return view('admin.discount.list',compact('discount'));
    }

    function create()
    {
        return view('admin.discount.create');
    }

    function store(Request $data)
    {
        $validator=Validator::make($data->all(),[
            'code'=>'required|unique:discounts,code',
            'type'=>'required',
            'name'=>'nullable',
            'description'=>'nullable',
            'discount_amount'=>'required|numeric',
            'status'=>'required',
            'max_uses'=>'nullable|numeric',
            'max_uses_user'=>'nullable|numeric',
            'min_amount'=>'nullable|numeric',
            'starts_at'=>'nullable|date|after_or_equal:today',
            'expires_at'=>'nullable|date|after:starts_at'
        ]);

        if($validator->passes())
        {
            $validatedData=$validator->validated();

            discount::create($validatedData);

            message('success','Discount saved successfully');

            return response()->json([
                'status'=>true,
            ]);
        }else
        {
            return response()->json([
                'status'=>false,
                'errors'=>$validator->errors()
            ]);
        }

    }


    function edit($id)
    {
        $discount=discount::find($id);

        return view('admin.discount.edit',compact('discount'));
    }

    function update(Request $data,$id)
    {
        $discount=discount::find($id);

        $validator=Validator::make($data->all(),[
            'code'=>'required|unique:discounts,code,'.$discount->id.',id',
            'type'=>'required',
            'name'=>'nullable',
            'description'=>'nullable',
            'discount_amount'=>'required|numeric',
            'status'=>'required',
            'max_uses'=>'nullable|numeric',
            'max_uses_user'=>'nullable|numeric',
            'min_amount'=>'nullable|numeric',
            'starts_at'=>'nullable|date|after_or_equal:today',
            'expires_at'=>'nullable|date|after:starts_at'
        ]);

        if($validator->passes())
        {
            $validatedData=$validator->validated();

            $discount->update($validatedData);

            message('success','Discount saved successfully');

            return response()->json([
                'status'=>true,
            ]);
        }else
        {
            return response()->json([
                'status'=>false,
                'errors'=>$validator->errors()
            ]);
        }

    }

    function delete($id)
    {
        $deleteDiscount=discount::find($id);

        $deleteDiscount->delete();

        return response()->json([
            'status'=>true,
            'message'=>'Discount deleted successfully',
            'id'=>$deleteDiscount->id
        ]);
    }
}
