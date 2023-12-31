<?php

namespace App\Http\Controllers;

use App\Models\product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class productController extends Controller
{
    function index($id)
    {
        $product=product::with('images')->find($id);
        $related = Product::with('images')
            ->where('id', '!=', $id)
            ->where(function ($query) use ($product) {
                $query->where('category_id', $product->category_id)
                    ->orWhere('sub_category_id', $product->sub_category_id)
                    ->orWhere('brand_id', $product->brand_id);
            })
            ->get();

        return view('home.product',compact('product','related'));
    }
}
