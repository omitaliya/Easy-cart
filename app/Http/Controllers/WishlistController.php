<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{

    function index()
    {
        $WishList=wishlist::with('product')->where('user_id',auth()->id())->get();

        return view('home.account.wishlist',compact('WishList'));
    }

    function removeProduct($id)
    {
        $delete_product=wishlist::where(['product_id'=>$id,'user_id'=>auth()->id()])->first();

        if($delete_product==null)
        {
            return response()->json([
                'status'=>false
            ]);
        }

        $delete_product->delete();

        return response()->json([
            'id'=>$id,
            'status'=>true,
            'message'=>'Product removed!',
        ]);
    }

    function addToWishlist(Request $data)
    {
        if(auth()->check()==false)
        {
            message('warning','Please login');
            return response()->json([
                'status'=>false
            ]);
        }
        
        wishlist::updateOrCreate([
            'product_id'=>$data->id,
            'user_id'=>auth()->id(),
        ],[
            'product_id'=>$data->id,
            'user_id'=>auth()->id(),
        ]);
        
        return response()->json([
            'status'=>true,
            'message'=>'Added to Wishlist!',
        ]);
    }
}
