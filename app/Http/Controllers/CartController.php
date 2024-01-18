<?php

namespace App\Http\Controllers;

use App\Models\address;
use App\Models\product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    function cart()
    {
        $cart=Cart::content();
        return view('home.cart',compact('cart'));
    }

    function addToCart(Request $data)
    {

        $pr=product::with('images')->where('id',$data->id)->first();

        if($pr)
        {
            $cart=Cart::content();
            $exists=false;

            foreach($cart as $i)
            {
                if($i->id==$pr->id)
                {
                    $exists=true;
                }
            }

            if($exists==false)
            {

                Cart::add($pr->id, $pr->title, 1, $pr->price,['pimg'=>$pr->images->first()]);

                $status=true;
                $message='Product Added In Cart.';
            }else
            {
                $status=false;
                $message='Product Already In Cart.';
            }
            
        }else
        {
            $status=false;
            $message='product not found';
        }

       

        return response()->json([
            'status'=>$status,
            'message'=>$message
        ]);
    }

    function updateCart(Request $data)
    {

        $info=Cart::get($data->id);
      
        $pr=product::find($info->id);
        $no_qty = null; 

        if($pr->track_qty=='1')
        {
            if($data->qty<=$pr->qty)
            {
                $cart=Cart::update($data->id, $data->qty);
            }else
            {
                $no_qty='Requested'. $data->qty. 'quantity not in the stoke!';
            }
        }else
        {
            $cart=Cart::update($data->id, $data->qty);
        }



        return response()->json([
            'status'=>true,
            'id'=>$data->id,
            'subtotal'=>Cart::subtotal(),
            'total'=>Cart::total(),
            'qty_into_price'=>$cart->price*$cart->qty,
            'no_qty'=>$no_qty,
            'pr'=>$pr,
        ]);
    }

    function deleteCart(Request $data)
    {
        Cart::remove($data->id);

        return response()->json([
        'message'=>'Product removed from cart!',
        'id'=>$data->id,
        'subtotal'=>Cart::subtotal(),
        'total'=>Cart::total(),
    ]);
    }

    function checkout()
    {
    
        if(Cart::count()==0)
        {
            return redirect()->route('cart');

        }

        $address=address::where('user_id',Auth::id())->get();
        
        return view('home.checkout',compact('address'));
    }
}
