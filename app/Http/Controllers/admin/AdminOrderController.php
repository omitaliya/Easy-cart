<?php

namespace App\Http\Controllers\admin;

use App\Models\order;
use App\Models\order_items;
use App\Models\order_status;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminOrderController extends Controller
{
    function index()
    {
        $order=order::with('discount','user','address')->paginate(10);
        $os=order_status::with('status')->latest()->first();
        return view('admin.order.list',compact('order','os'));
    }

    function orderDetail($id)
    {
        $detail=order::with('discount','user','address')->where('id',$id)->first();
        $items=order_items::with('order','product')->where('order_id',$id)->get();
        $status=order_status::where('order_id',$id)->latest()->first();
        return view('admin.order.orderDetail',compact('items','detail','status'));
    }

    function order_status(Request $data)
    {
        $os=new order_status;

        $os->name=$data->status;
        $os->date=now();
        $os->order_id=$data->order_id;
        $os->save();

        return response()->json([
            'message'=>'Order Status updated!'
        ]);
    }
}
