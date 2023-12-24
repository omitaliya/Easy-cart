<?php

namespace App\Http\Controllers\admin;

use App\Models\Category;
use App\Models\sub_categories;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class SubCategoryController extends Controller
{
    function index(Request $r)
    {
        $category=Category::orderBy('name','ASc')->get();
        $sub_category=sub_categories::with('category')->latest();

        if($r->get('keyword'))
        {
            $sub_category=$sub_category->where('name','like','%'.$r->keyword.'%');
        }

        $sub_category=$sub_category->paginate(10);

        return view('admin.sub-category.list',compact('category','sub_category'));
    }

    function create(Request $data)
    {
        $category=Category::orderBy('name','ASc')->get();

        return view('admin.sub-category.create',compact('category'));
    }

    function edit($id)
    {
        $category=Category::orderBy('name','ASc')->get();
        $sub_category=sub_categories::find($id);

        return view('admin.sub-category.edit',compact('category','sub_category'));
    }

    function update($id,Request $data)
    {
        $sub_cat=sub_categories::find($id);

        {
            $validator=Validator::make($data->all(),[
    
                'name'=>'required',
                'slug'=>'required|unique:sub_categories,slug,'.$sub_cat->id.'',
                'category'=>'required'
            ]);
    
            if($validator->passes())
            {
                $sub_cat->name=$data->name;
                $sub_cat->slug=$data->slug;
                $sub_cat->category_id=$data->category;
                $sub_cat->status=$data->status;
                $sub_cat->save();
    
                session()->flash('success','Sub Category Updated Successfully!');
    
                return response()->json([
                    'message'=>'success',
                    'status'=>true
                ]);
    
            }else{
                return response()->json([
                'errors'=>$validator->errors(),
                'status'=>false,
                'message'=>'failed to update category'
                ]);        
            }
    
        }
    }
    
    function store(Request $data)
    {
        $validator=Validator::make($data->all(),[

            'name'=>'required',
            'slug'=>'required|unique:sub_categories,slug',
            'category'=>'required'
        ]);

        if($validator->passes())
        {
            $sub_cat=new sub_categories;

            $sub_cat->name=$data->name;
            $sub_cat->slug=$data->slug;
            $sub_cat->category_id=$data->category;
            $sub_cat->status=$data->status;
            $sub_cat->save();

            session()->flash('success','Sub Category Added Successfully!');

            return response()->json([
                'message'=>'success',
                'status'=>true
            ]);

        }else{
            return response()->json([
            'errors'=>$validator->errors(),
            'status'=>false,
            'message'=>'failed to add category'
            ]);        
        }

    }

    function delete($id)
    {
        $sub_cat=sub_categories::find($id);
        $sub_cat->delete();

        session()->flash('success','category deleted successfully');
    }


}
