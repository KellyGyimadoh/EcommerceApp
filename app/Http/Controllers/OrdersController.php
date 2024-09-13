<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use App\Http\Requests\StoreOrdersRequest;
use App\Http\Requests\UpdateOrdersRequest;
use App\Models\CartItems;
use App\Models\Carts;
use App\Models\OrderItems;
use App\Models\Products;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $user=Auth::user();
        $orders= Orders::with('orderitems')->with('user')->with('payments')->where('user_id',$user->id)->latest()->paginate(6);
        $totalorders=Orders::where('user_id',$user->id)->where('order_status',0)->count();

        return view('orders.index',['orders'=>$orders,'user'=>$user,'totalorders'=>$totalorders,'orderitems'=>'']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users=User::all();
        return view('orders.create',['users'=>$users]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrdersRequest $request)
    {
        $validatedData= $request->validated();

        $user=User::findOrFail($validatedData['user_id']);
        $cart=Carts::where('user_id',$user->id)->first();

        $cartitems= CartItems::with('product')->where('cart_id',$cart->id)->get();
        if ($cartitems->isEmpty()) {
            return redirect()->back()->with('error', 'Your cart is empty.');
        }
        $totalAmount=$cartitems->sum(function($cartitem){
            return $cartitem->quantity * $cartitem->product->price;
        });
        if($validatedData['total_price']!=$totalAmount){
            return redirect()->back()->with('error','Total Amount Not correct!!');
        }

       $order= Orders::create(array_merge($validatedData,['total_price'=>$totalAmount]));
       $order->save();
       foreach($cartitems as $cartitem)
       { OrderItems::create([
        'order_id'=>$order->id,
        'products_id'=>$cartitem->product->id,
        'quantity'=>$cartitem->quantity,
        'price'=>$cartitem->product->price
       ]);
        // Optionally, subtract the ordered quantity from available stock
       // $cartitem->product->decrement('available_quantity', $cartitem->quantity);
    }
       $products=Products::all();
       $cartitems->each->delete();
        return redirect()->route('orders.index')->with(['success'=>'Order Processed Successfully! On Pending','orders'=>$order,'products'=>$products,
        'user'=>$user]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Orders $orders)
    {
        if($orders){
            return response()->json(['success'=>true,'data'=>$orders]);
        }else{
            return response()->json(['data'=>[],'success'=>false]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function processCartItems(User $user){

        $cart= Carts::where('user_id',$user->id)->first();
        $cartitems=CartItems::with('product')->where('cart_id',$cart->id)->get();

        $totalAmount=$cartitems->sum(function($cartitem){
            return $cartitem->quantity * $cartitem->product->price;
        });
        return view('orders.processcart',['totalAmount'=>$totalAmount,'user'=>$user,'cartitems'=>$cartitems]);
    }
    public function edit(Orders $orders)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrdersRequest $request, Orders $orders)
    {
        $validatedData= $request->validated();
        $orders->updateOrFail($validatedData);
        if($orders->saveOrFail()){
            return back()->with('success','Order Updated');
        }else{
            return back()->with('error','Failed to Updated Try again');
        }

    }
    public function success(){
        return redirect()->route('orders.index')->with('success','Payment successfully made');
    }
    public function cancel(){
        return redirect()->route('orders.index')->with('error','there was an error processing your payment');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Orders $orders)
    {

        $action= $orders->delete();
        if($action){
            return back()->with('success','Order Removed Successfully');
        }else{
            return back()->with('error','Failed to remove Order please try again..');
        }


    }
}
