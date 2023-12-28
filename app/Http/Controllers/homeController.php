<?php

namespace App\Http\Controllers;

use App\Models\product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class homeController extends Controller
{
    function index()
    {
        $featured_product=product::with('images')
        ->where('is_featured',1)
        ->where('status',1)
        ->take(8)->get();
        
        $latest_product=product::with('images')
        ->where('status',1)
        ->latest()->take(8)->get();

        return view('home.home',compact('featured_product','latest_product'));
    }
}
