<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Http\Requests\StoreCategoriesRequest;
use App\Http\Requests\UpdateCategoriesRequest;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories=Categories::query()->latest()->paginate(4);

        return view ('categories.index',['categories'=>$categories]);
    }

    public function search(Request $request)

    {
        $categorytype=$request->input('categorytype','all');
        $querySearch= $request->input('q','all');

        $categoryQuery= Categories::query();
        if($categorytype!=='all'){
            $categoryQuery->where('name',$categorytype);
        }
        if($querySearch && $querySearch!=='all'){
            $categoryQuery->where('name','LIKE','%'.$querySearch.'%');
        }
        $categories= $categoryQuery->latest()->paginate(4)->appends(['q'=>$querySearch,'categorytype'=>$categorytype]);

        return view('categories.index',['categories'=>$categories]);
        //
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoriesRequest $request)
    {
        $validatedData= $request->validated();

        $newcategory=Categories::createOrFirst($validatedData);
        if($newcategory){
        return back()->with('success','New Category added successfully');
        }else{
        return back()->with('error','Failed to add new category');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Categories $categories)
    {
        if($categories)
        {
            return response()->json(['data'=>$categories,'success'=>true]);
        }else{
            return response()->json(['data'=>[],'success'=>false]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categories $categories)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoriesRequest $request, Categories $categories)
    {
        $newCategory= $request->validated();

        $categories->updateOrFail($newCategory);
        $categories->save();
        return back()->with('success','Update successful');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categories $categories)
    {
       $action= $categories->delete();


        if($action){

            return  back()->with('success','category removed');
        }else{
            return back()->with('error','failed to removed category');
        }
    }
}
