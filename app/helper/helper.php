<?php

use App\Models\brand;
use App\Models\Category;
use App\Models\product;

function getCategory()
{
    return Category::with('sub_category')->where('status', 1)->orderBy('name','ASC')->get();
}

function brand()
{
    return brand::where('status',1)->orderBy('name','ASC')->get();
}

function product()
{
    return product::with('images')->where('status',1)->orderBy('title','ASC')->paginate(8);
}

?>