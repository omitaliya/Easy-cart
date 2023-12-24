<?php

namespace App\Http\Controllers\admin;

use App\Models\brand;
use App\Models\Category;
use App\Models\image;
use App\Models\product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class productController extends Controller
{
    function index()
    {
        return view('admin.product.list');
    }
    function create()
    {
        $brand=brand::all();
        $category=Category::all();


        return view('admin.product.create',compact('category','brand'));
    }

    function store(Request $data)
    {
        $rules=[
            'title' =>'required',
            'slug' =>'required',
            'description' =>'required',
            'price' =>'required|numeric',
            'compare_price' =>'nullable|numeric',
            'image' =>'required',
            'sku'=>'required',
            'category' =>'required',
        ];

        if($data->track_qty==1)
        {
            $rules['qty']='required|numeric';
        }

        $validator=Validator::make($data->all(),$rules);

        if($validator->passes())
        {
            $product=new product;

            $product->title=$data->title;
            $product->slug=$data->slug;
            $product->description=$data->description;
            $product->price=$data->price;
            $product->compare_price=$data->compare_price;
            $product->sku=$data->sku;
            $product->category_id=$data->category;
            $product->sub_category_id=$data->sub_category;
            $product->brand_id=$data->brand;
            $product->status=$data->status;
            $product->is_featured=$data->is_featured;
            $product->track_qty=$data->track_qty;
            $product->qty=$data->qty;
            $product->save();

            $images=$data->file('image');

            foreach($images as $img)
            {
                $img_name=time().rand(0,9).'.'.$img->getClientOriginalExtension();
                $path=$img->storeAs('upload',$img_name,'public');
                
                $save_image=new image;
                $save_image->product_id=$product->id;
                $save_image->path=$path;
            $save_image->save();

            }

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
}
