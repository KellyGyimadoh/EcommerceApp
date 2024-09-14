<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Orders;
use App\Models\Payments;
use App\Models\Products;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index()
    {
        $categories=Categories::all()->count();
        $products=Products::all()->count();
        $ordersAll=Orders::all()->count();
        $ordersPending=Orders::where('order_status',0)->count();
        $ordersProcessing=Orders::where('order_status',1)->count();
        $ordersCompleted=Orders::where('order_status',3)->count();
        $totalSales=Payments::all()->sum('amount_paid');

        return view('activity.index',['productsTotal'=>$products,
    'categoriesTotal'=>$categories,'ordersAll'=>$ordersAll,'ordersPending'=>$ordersPending,
    'ordersProcessing'=>$ordersProcessing,'ordersCompleted'=>$ordersCompleted,
    'totalSalesAll'=>$totalSales
    ]);

    }
}
