<?php

namespace App\Http\Controllers;

use App\ProductSale;
use App\Store;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    /*public function __construct()
    {
        $this->middleware('auth');
    }*/

    /*function __construct()
    {
        $this->middleware('permission:home-list', ['only' => ['index']]);
    }*/


    public function index()
    {
        //return view('home');
        //return view('backend._partial.home',['customers'=>$customer,'totalDue'=>$totalDue,'todaySell'=>$todaySell,'todayDue'=>$todayDue,'todaPaid'=>$todayPaid,'todayInvoice'=>$todayInvoice]);



        $stores = Store::all();
        $total_due = ProductSale::where('due_amount','>',0)->sum('due_amount');
        return view('backend._partial.home', compact('stores','total_due','productSales'));
    }
}
