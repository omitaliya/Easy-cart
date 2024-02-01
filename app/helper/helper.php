<?php

use App\Models\brand;
use App\Models\image;
use App\Models\order;
use App\Models\product;
use App\Mail\OrderEmail;
use App\Models\Category;
use App\Models\order_items;
use App\Models\order_status;
use Illuminate\Support\Facades\Mail;

function message($class,$msg)
{
    $cls='add'.$class;
    notyf()
    ->position('x', 'center')
    ->position('y', 'bottom') 
    ->$cls($msg);
}
function getCategory()
{
    return Category::with('sub_category')->where('status', 1)->orderBy('name','ASC')->get();
}

function brand()
{
    return brand::where('status',1)->orderBy('name','ASC')->get();
}


function formateDate($date)
{
                if ($date === null) {
                    return null;
                }
    return date('d-M-Y h:i A',strtotime($date));
}
function onlyDate($date)
{
                if ($date === null) {
                    return null;
                }
    return date('d-M-Y',strtotime($date));
}

function getImage($id)
{
    return image::where('product_id',$id)->first();
}

function orderEmail($id)
{   
        $detail=order::with('discount','user','address')->where('id',$id)->first();
        $items=order_items::with('order','product')->where('order_id',$id)->get();

        $mailData=[
            'subject'=>'Order Placed!',
            'detail'=>$detail,
            'items'=>$items,
        ];

        Mail::to($detail->address->email)->send(new OrderEmail($mailData));
}

