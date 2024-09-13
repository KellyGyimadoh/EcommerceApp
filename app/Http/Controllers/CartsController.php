<?php

namespace App\Http\Controllers;

use App\Models\Carts;
use App\Http\Requests\StoreCartsRequest;
use App\Http\Requests\UpdateCartsRequest;
use App\Models\CartItems;
use App\Models\Categories;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products=Products::query()->latest()->paginate(5);
        $categories=Categories::all();
        $user=Auth::user()->id;
        $cart=Carts::where('user_id',$user)->first();
        $cartid= $cart? $cart->id :null;
        session(['cartid' => $cartid]);
         $cartTotalItems = CartItems::where('cart_id', $cartid)->sum('quantity');



        return view('carts.index',['products'=>$products,'categories'=>$categories,'totalItems'=>$cartTotalItems]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function search(Request $request){
        $category=$request->input('producttype','all');
        $item= $request->input('q','all');

       $searchQuery= Products::query();
       $categories= Categories::query()->get();
       if($category && $category!=='all'){
        $searchQuery->where('category_id',$category);
       }
       if($item && $item!=='all'){
        $searchQuery->where('name','LIKE','%'.$item.'%');
       }

       $products= $searchQuery->with('category')->latest()
       ->paginate(5)->appends(['producttype'=>$category,'q'=>$item]);
       $user=Auth::user()->id;
       $cart=Carts::where('user_id',$user)->first();
       $cartid= $cart? $cart->id :null;

       $cartTotalItems = CartItems::where('cart_id', $cartid)->sum('quantity');


       return view('carts.index',['products'=>$products,'categories'=>$categories,'totalItems'=>$cartTotalItems]);
    }
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCartsRequest $request)
    {

        $validatedData= $request->validated();
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

    /**
     * Display the specified resource.
     */
    public function show(Carts $carts)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Carts $carts)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCartsRequest $request, Carts $carts)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Carts $carts)
    {
        $action= $carts->deleteOrFail();
        if($action){
            return back()->with('success','Cart removed');
        }else{
            return back()->with('error','failed to remove cart try again!');
        }
    }
}
