<?php

namespace App\Http\Controllers;

use App\Models\product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\sub_categories;

class shopController extends Controller
{
    function index(Request $req)
    {

        $selected_category='';
        $selected_sub_category='';
        $selected_brands = $req->brands;
        

        $product=product::query();

        if(!empty($req->CategorySlug))
        {
            $cat=Category::where('slug',$req->CategorySlug)->first();
            $product=$product->where('category_id',$cat->id);
            $selected_category=$cat->id;
            
        }

        if((!empty($req->get('search'))))
        {
            $product=$product->where('title','like','%'.$req->get('search').'%');
        }

        
        if ($req->ajax()) {
            if(!empty($selected_brands))
            {
                $product=$product->with('images')->whereIn('brand_id',$selected_brands)->get();
                return response()->json([
                    'status'=>true,
                    'product'=>$product
                ]);
            }else{
                $product=$product->with('images')->get();
                return response()->json([
                    'status'=>true,
                    'product'=>$product
                ]);
            }
      }

     

      if (!empty($req->sort)) {
        switch ($req->sort) {
            case 'high':
                $product->orderBy('price','DESC');
                break;
            case 'low':
                $product->orderBy('price','ASC');
                break;
            case 'latest':
                $product->orderBy('id','DESC');
                break;
            default:
                $product=$product->with('images');
                break;
        }
    }

  
        
        if(!empty($req->SubCategorySlug))
        {
            $sub_cat=sub_categories::where('slug',$req->SubCategorySlug)->first();
            $product=$product->where('sub_category_id',$sub_cat->id);
            $selected_sub_category=$sub_cat->id;

        }

       


        $product=$product->with('images')->where('status',1)->orderBy('title','ASC')->paginate(6);


        return view('home.shop',compact('product','selected_sub_category','selected_category'));
    }
}