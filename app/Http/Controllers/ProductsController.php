<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Http\Requests\StoreProductsRequest;
use App\Http\Requests\UpdateProductsRequest;
use App\Models\Categories;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products=Products::with('category')->latest()->paginate(5);
        $categories= Categories::query()->get();

        return view('products.index',['products'=>$products,'categories'=>$categories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories= Categories::query()->get();
        return view('products.create',['categories'=>$categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductsRequest $request)
    {
        $validatedData= $request->validated();

        $imageurl=$request->file('image') ?$request->file('image')->store('productimages','public') : null;

       $action= Products::createOrFirst($validatedData,['image'=>$imageurl]);
        if($action){
            return back()->with('success','Product added successfully');
        }else{
            return back()->with('error','Failed to add product');

        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Products $products)
    {
        $products->status = $products->status ? 'Expired': 'Not Expired';


        if($products)

        {
            return response()->json(['data'=>$products,'success'=>true]);
        }else{
            return response()->json(['data'=>[],'success'=>false]);
        }  }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Products $products)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductsRequest $request, Products $products)
    {

        $validatedData= $request->validated();
        $currentDate=Carbon::now();
        if($request->expiry_date<=$currentDate){
            $status=1;
        }else{
            $status=0;
        }

        if($request->hasFile('image')){
            if($products->image){
                Storage::delete($products->image);
            }
            $imageurl= $request->file('image')->store('productimages','public');
        }else{
            $imageurl=$products->image;
        }
       $action= $products->update(array_merge($validatedData,['image'=>$imageurl,'status'=>$status]));


        if($action){
            return back()->with('success','Product update successful');
        }else{
            return back()->with('error',' update failed!');

        }
    }
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

       return view('products.index',['products'=>$products,'categories'=>$categories]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Products $products)
    {

       $action= $products->deleteOrFail();
        return $action ? back()->with('success','product removed successfully'):
        back()->with('error','failed to remove try again..');
    }
}
