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
        $percentAmount=0;
        $newAmount=0;
        $did=null;
        
        $address_id=address::where('user_id',Auth::id())->pluck('id')->first();

        if(session()->has('code'))
        {
            $code=session()->get('code');
            $did=$code->id;

            if($code->type=='percent')
            {
                $subTotal = str_replace(',', '', Cart::subtotal()); 
                $percentAmount = ($code->discount_amount / 100) * floatval($subTotal);
                $newAmount = floatval($subTotal) - $percentAmount;
                
            }elseif($code->type=='fixed')
            {
                $subTotal = str_replace(',', '', Cart::subtotal());
                $percentAmount = $code->discount_amount;
                $newAmount = floatval($subTotal) - $code->discount_amount;
                
            }

        }

        if($data->payment=='cod')
        {
           

            $order=new order;

            $order->date=now();
            $order->total = ($newAmount !== 0) ? $newAmount : str_replace(',', '', Cart::subtotal());
            $order->status='Pending';
            $order->user_id=Auth::id();
            $order->discount_id=$did;
            $order->damount=$percentAmount;
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
            session()->forget('code');

                message('success','Order Placed Successfully!');

                return response()->json([
                    'status'=>true,
                    'percentAmount'=>$percentAmount,
                    'newAmount'=>$newAmount
                ]);
        }else
        {
            echo 'online payment';
        }

    }

}
