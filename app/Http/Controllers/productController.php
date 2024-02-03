<?php

namespace App\Http\Controllers;

use App\Models\order_items;
use App\Models\product;
use App\Models\product_rating;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class productController extends Controller
{
    function index($id)
    {
        $product_ids=null;
        $allowed=true;

        if(Auth::check())
        {
            $product_ids=order_items::where('user_id',auth()->id())->distinct()->pluck('products_id')->toArray();
            $count_rating=product_rating::where('user_id',auth()->id())->count();
        }
        if($count_rating>0)
        {
            $allowed=false;
        }

        $product=product::with('images')->find($id);

        $total_rating=product_rating::where('product_id',$id)->distinct()->count();
        $sum_rating=product_rating::where('product_id',$id)->distinct()->sum('rating');
        $avg_rating=product_rating::where('product_id',$id)->distinct()->avg('rating');
        $avg_rating_percentage=($avg_rating*100)/5;

        $rating=product_rating::where('product_id',$id)->with('product','user')->get();

        $related = Product::with('images')
            ->where('id', '!=', $id)
            ->where(function ($query) use ($product) {
                    $query->where('category_id', $product->category_id)
                        ->orWhere('sub_category_id', $product->sub_category_id)
                        ->orWhere('brand_id', $product->brand_id);
                    })
            ->get();

        return view('home.product',compact('product','related','product_ids','allowed','total_rating','sum_rating','rating','avg_rating','avg_rating_percentage'));
    }
}
