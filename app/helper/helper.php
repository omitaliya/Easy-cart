<?php

use App\Models\Category;

function getCategory()
{
    return Category::with('sub_category')->where('status', 1)->orderBy('name','ASC')->get();
}

?>