<?php

namespace App\Http\Controllers;

use App\Models\product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;

class homeController extends Controller
{
    function index()
    {
        $categories=Category::withCount('product')->where('status',1)->get();

        $featured_product=product::with('images')
        ->where('is_featured',1)
        ->where('status',1)
        ->take(8)->get();
        
        $latest_product=product::with('images')
        ->where('status',1)
        ->latest()->take(8)->get();

        return view('home.home',compact('featured_product','latest_product','categories'));
    }
}
