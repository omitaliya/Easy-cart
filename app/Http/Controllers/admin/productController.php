<?php

namespace App\Http\Controllers\admin;

use App\Models\brand;
use App\Models\image;
use App\Models\product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\sub_categories;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class productController extends Controller
{
    function index()
    {
        $products=product::with('images','brand','category','sub_category')->orderBy('id','desc')->paginate(10);
        return view('admin.product.list',compact('products'));
    }
    function create()
    {
        $brand=brand::all();
        $category=Category::all();


        return view('admin.product.create',compact('category','brand'));
    }

    function delete($id)
    {
        $product=product::find($id);

        foreach($product->images as $img)
        {
            Storage::disk('public')->delete('upload',$img->path);
        }
        $product->images->each->delete();
        $product->delete();


        return response()->json([
            'status'=>true,
            'message'=>'Product deleted successfully',
            'id'=>$id
        ]);
    }

    function edit($id)
    {
        $product=product::with('images')->find($id);

        $sub_category=sub_categories::where('category_id',$product->category_id)->get();
        $brand=brand::all();
        $category=Category::all();
        return view('admin.product.edit',compact('product','category','brand','sub_category'));
    }

    function update($id,Request $data)
    {
        $product=product::find($id);
        $rules=[
            'title' =>'required',
            'slug' =>'required|unique:products,slug,'.$product->id.'id',
            'description' =>'required',
            'price' =>'required|numeric',
            'compare_price' =>'nullable|numeric',
            'image' =>'nullable',
            'sku'=>'required|unique:products,sku,'.$product->id.'id',
            'category' =>'required',
        ];

        if($data->track_qty==1)
        {
            $rules['qty']='required|numeric';
        }

        $validator=Validator::make($data->all(),$rules);

        if($validator->passes())
        {

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
            $product->track_qty=$data->track_qty ? 1: 0;
            $product->qty=$data->qty;
            $product->save();

            $images=$data->file('image');

            if($images!=null)
            {

                foreach($images as $img)
                {
                    $img_name=time().rand(0,9).'.'.$img->getClientOriginalExtension();
                    $path=$img->storeAs('upload',$img_name,'public');
                    
                    $save_image=new image;
                    $save_image->product_id=$product->id;
                    $save_image->path=$path;
                $save_image->save();
    
                
            }
        }
        session()->flash('success', 'Product updated successfully');

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

    function store(Request $data)
    {

        $rules=[
            'title' =>'required',
            'slug' =>'required|unique:products,slug',
            'description' =>'required',
            'price' =>'required|numeric',
            'compare_price' =>'nullable|numeric',
            'image' =>'required',
            'sku'=>'required|unique:products,sku',
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
            $product->track_qty=$data->track_qty ? 1:0;
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

            session()->flash('success', 'Product saved successfully');

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

    function deleteImage($id)
    {
        $img=image::find($id);

        Storage::disk('public')->delete('upload',$img->path);

        $img->delete();

        return response()->json([
            'message'=>'Image deleted successfully',
            'id'=>$img->id
        ]);
    }
}
