<?php

namespace App\Http\Controllers\admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    function index(Request $request)
    {
        $categories=category::latest();

        if(!empty($request->get('keyword')))
        {
                $categories=$categories->where('name','like','%'.$request->get('keyword').'%');
        }

        $categories=$categories->paginate(10);

        return view('admin.category-list',compact('categories'));
    }

    function create()
    {
        return view('admin.create-category');
    }
    function store(Request $data)
    {
        $validator=Validator::make($data->all(),[
            'name'=>'required',
            'slug'=>'required|unique:categories,slug',

        ]);

        if($validator->passes())
        {
            $category=new Category;

            $category->name=$data['name'];
            $category->slug=$data['slug'];
            $category->status=$data['status'];
            $category->save();

            redirect('category-list')->with('success','Category saved successfully!');
            
            return response()->json([
                
                'status' => true,
                'message' => 'category added successfully',
                
            ]);
            

        }else
        {
            return response()->json([

                'status'=>false,
                'errors'=>$validator->errors(),
                'message'=>'failed to add category'

            ]);

        }
    }

    function edit($id)
    {
        $category=Category::find($id);

        if($category==null)
        {
            return redirect()->route('category.list');
        }
        
        return view('admin.category-edit')->with(compact('category'));

    }

    function update($id,Request $data)
    {
        $category=category::find($id);

        $validator=Validator::make($data->all(),[
            'name'=>'required',
            'slug'=>'required|unique:categories,slug,'.$category->id.'',
        ]);

        if($validator->passes())
        {
            $category=new Category;

            $category->name=$data['name'];
            $category->slug=$data['slug'];
            $category->status=$data['status'];
            $category->save();

            redirect('category-list')->with('success','Category updated successfully!');
            
            return response()->json([
                
                'status' => true,
                'message' => 'category updated successfully',
                
            ]);
        }
        else
        {
            return response()->json([
                'status'=>false,
                'errors'=>$validator->errors(),
            ]);
        }
    }

    function delete($id)
    {
        $delete_id=category::find($id);

        if(empty($delete_id))
        {

            session()->flash('success','Category not found!');
        }else
        {

            session()->flash('success','Successfully deleted');
            $delete_id->delete();
        }
        


        return response()->json([
            'status'=>true,
            'message'=>'Delete successfully',
        ]);
    }
}
