<?php

namespace App\Http\Controllers\admin;

use App\Models\order;
use App\Models\product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $totalOrder=order::whereHas('orderStatus', function ($query) {
                    $query->where('name', '<>', 'cancelled');
                    })->count();

        $totalProduct=product::count();

        $totalSale=order::whereHas('orderStatus',function($query)
                    {
                             $query->where('name','<>','cancelled');
                    })->sum('total');

        $lastMonthSale=order::whereBetween('created_at',[now()->subMonth()->startOfMonth(),now()->subMonth()->endOfMonth()])->whereHas('orderStatus',function($query){
                         $query->where('name','<>','cancelled');
                         })->sum('total');

        $quartlySale=order::whereBetween('created_at',[now()->firstOfQuarter(),now()->lastOfQuarter()])->whereHas('orderStatus',function($query){
                         $query->where('name','<>','cancelled');
                         })->sum('total');

        $thisMonthSale=order::whereBetween('created_at',[now()->startOfMonth(),now()->endOfMonth()])->whereHas('orderStatus',function($query){
                         $query->where('name','<>','cancelled');
                          })->sum('total');


        return view('admin/dashboard')->with([
            'totalOrder'=>$totalOrder,
            'totalProduct'=>$totalProduct,
            'totalSale'=>$totalSale,
            'lastMonthSale'=>$lastMonthSale,
            'quartlySale'=>$quartlySale,
            'thisMonthSale'=>$thisMonthSale
        ]);

    }

    function logout(){
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
