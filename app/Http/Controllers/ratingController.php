<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\product_rating;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ratingController extends Controller
{
    function saveRating(Request $data)
    {
      $validator=Validator::make($data->all(),
      [
        'rating'=>'required|min:1|max:5',
        'review'=>'required'
      ]);

      if($validator->passes())
      {
        $rating=new product_rating;

        $rating->rating=$data->rating;
        $rating->comment=$data->review;
        $rating->product_id=$data->product_id;
        $rating->user_id=Auth::id();
        $rating->save();
        
        message('info','Review Submitted!');

        return response()->json([
          'status'=>true
        ]);
      }else
      {
        return response()->json([
          'status'=>false,
          'errors'=>$validator->errors(),
        ]);
      }
    }
}
