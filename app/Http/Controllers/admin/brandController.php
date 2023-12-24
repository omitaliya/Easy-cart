<?php

namespace App\Http\Controllers\admin;

use App\Models\brand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class brandController extends Controller
{
    public function index(Request $req)
    {
        $brand=brand::latest();

        if($req->get('keyword'))
        {
            $brand=$brand->where('name','like','%'.$req->keyword.'%');
        }

        $brand=$brand->paginate(10);

        return view('admin.brands.list',compact('brand'));
    }

    public function create()
    {
        return view('admin.brands.create');
    }
    public function store(Request $data)
    {
        $validator=Validator::make($data->all(),[
            'name'=>'required',
            'slug'=>'required|unique:brand,slug'
        ]);

        if($validator->passes())
        {
            $brand=new brand;
            $brand->name=$data->name;
            $brand->slug=$data->slug;
            $brand->status=$data->status;
            $brand->save();

            session()->flash('success','Brand Added Successfully!');

            return response()->json([
                'status' => true,
            ]);

        }else
        {
        return response()->json([
            'errors'=>$validator->errors(),
            'status'=>false
        ]);
        }
    }

    function delete($id)
    {
        $delete=brand::find($id)->delete();
        session()->flash('success','Brand was successfully deleted');
    }

    function edit($id)
    {
        $brand=brand::find($id);

        return view('admin.brands.edit',compact('brand'));
    }

    function update($id, Request $r)
{   
    $b=brand::find($id);

    $validator=Validator::make($r->all(),
    [
        'name' => 'required',
        'slug'=>'required|unique:brand,slug,'.$b->id.'',
    ]);

    if($validator->passes())
    {
        $b->name=$r->name;
        $b->slug=$r->slug;
        $b->status=$r->status;

        $b->save();

        session()->flash('success','Brand Update Success!');
        return response()->json([
            'status'=>true
        ]);
    }
    else{
        return response()->json([
                'errors' => $validator->errors(),
                'status'=>false
        ]);
    }
}


}
