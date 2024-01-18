<?php

namespace App\Http\Controllers;

use App\Models\order;
use App\Models\address;
use App\Models\order_items;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Gloudemans\Shoppingcart\Facades\Cart;

class orderController extends Controller
{
    function save(Request $data)
    {
        $address_id=address::where('user_id',Auth::id())->pluck('id')->first();

        if($data->payment=='cod')
        {
            $order=new order;

            $order->date=now();
            $order->total=str_replace(',', '', Cart::subtotal());
            $order->status='Pending';
            $order->user_id=Auth::id();
            $order->payment_method=$data->payment;
            $order->addresses_id=$address_id;
            $order->save();

            foreach(Cart::content() as $item)
            {
            $order_item=new order_items;

                $order_item->user_id=Auth::id();
                $order_item->order_id=$order->id;
                $order_item->products_id=$item->id;
                $order_item->qty=$item->qty;
                $order_item->price=$item->price;

                $order_item->save();
                
            }
            Cart::destroy();

                message('success','Order Placed Successfully!');

                return response()->json([
                    'status'=>true
                ]);
        }else
        {
            echo 'online payment';
        }
    }
}
