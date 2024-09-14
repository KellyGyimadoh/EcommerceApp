<?php

namespace App\Http\Controllers;

use App\Models\CartItems;
use App\Models\Carts;
use App\Models\Products;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(){
        $products=Products::with('category')->get();
        $user=Auth::user();
        $cart=Carts::where('user_id',$user->id)->first();
        $cartid= $cart? $cart->id :null;
        session(['cartid' => $cartid]);
        $cartTotalItems = CartItems::where('cart_id', $cartid)->sum('quantity');
        session(['totalCartItems'=>$cartTotalItems]);
        return view('home',['products'=>$products,'totalItems'=>$cartTotalItems]);
    }


    public function store(Request $request)
    {

        $validatedData= $request->validate([
            'user_id'=>['required'],
            'product_id'=>['required'],
            'quantity'=>['required']
        ]);
       $cart= Carts::firstOrCreate(['user_id'=>$validatedData['user_id']]);
       $quantity=$validatedData['quantity'];
       CartItems::create([
        'cart_id'=>$cart->id,
        'product_id'=>$validatedData['product_id'],
        'quantity'=>$quantity
       ]);

       $productname=Products::findOrFail($validatedData['product_id']);
        return back()->with(['success'=>$quantity.' '.$productname->name. ' added to cart','cartid'=>$cart->id]);
    }
}
