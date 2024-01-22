<?php

namespace App\Http\Controllers;

use App\Models\order;
use App\Models\address;
use App\Models\product;
use App\Models\discount;
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

    function applyCoupon(Request $data)
    {
        $subTotal = str_replace(',', '', Cart::subtotal()); 

        $code=discount::where('code',$data->code)->first();
        if($code!=null)
        {
            $max_uses=order::where('discount_id',$code->id)->count();
            $max_uses_user=order::where(['discount_id'=>$code->id, 'user_id'=>Auth::id()])->count();
        }

        $total=0;
        $damount=0;

        if($code==null)
        {
            $status=false;
            $message='Coupon not found';
        }
        elseif($code->expires_at<=now())
        {
            $status=false;
            $message='Coupon expired';
        }
        elseif($max_uses >= $code->max_uses)
        {
            $status=false;
            $message='Coupon max uses exceeded';
        }
        elseif($max_uses_user >= $code->max_uses_user)
        {
            $status=false;
            $message='You have used this coupon';
        }
        elseif($subTotal < $code->min_amount)
        {
            $status=false;
            $message='Your minimum total should be ₹'.$code->min_amount;
        }else
        {
                session()->put('code',$code);

              

                if($code->type=='percent')
                {
                    
                    $percentAmount = ($code->discount_amount / 100) * floatval($subTotal);
                    $newAmount = floatval($subTotal) - $percentAmount;
                    
                    
    
                }elseif($code->type=='fixed')
                {
                    $percentAmount = $code->discount_amount;
                    $newAmount = floatval($subTotal) - $code->discount_amount;
                    
                }
                  
                $status=true;
                $message=$newAmount;
                $total=$newAmount;
                $damount=$percentAmount;

        }


        return response()->json([
            'status'=>$status,
            'message'=>$message,
            'total'=>$total,
            'damount'=>$damount,
        ]);

     
    }

}
