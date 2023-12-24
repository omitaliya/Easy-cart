<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\sub_categories;
use Illuminate\Http\Request;

class productSubCategory extends Controller
{
    function index(Request $req)
    {
       if(!empty($req->category_id))
       {

           $subCategory=sub_categories::where('category_id',$req->category_id)->orderBy('name','ASC')->get();
   
           return response()->json([
               'status'=>true,
               'sub_category'=>$subCategory
           ]);
       }else
       {
        return response()->json([
            'status'=>true,
            'sub_category'=>[]
        ]);
       }
    }
}
