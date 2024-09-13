<?php

namespace App\Http\Controllers;

use App\Models\CartItems;
use App\Http\Requests\StoreCartItemsRequest;
use App\Http\Requests\UpdateCartItemsRequest;
use App\Models\Categories;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCartItemsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(CartItems $cartItems)
    {

        if ($cartItems) {
            $productname = $cartItems->product->name;
            $quantity = $cartItems->quantity;
            $price = $cartItems->product->price;
            $product_id = $cartItems->product_id;
            return response()->json([
                'success' => true,
                'data' => array_merge([
                    'price' => $price,
                    'productname' => $productname,
                    'quantity' => $quantity,
                    'product_id' => $product_id
                ])
            ]);
        } else {
            return response()->json(['data' => [], 'success' => false]);
        }
    }

    public function viewCartItems($cartid)
    {

        $cartitems = CartItems::with('product')->where('cart_id', $cartid)->paginate(5);
        $categories = Categories::all();

        // Convert the paginated result to a collection
        $cartitemsCollection = collect($cartitems->items());

        $totalAmount = $cartitemsCollection->sum(function ($cartitem) {
            return $cartitem->quantity * $cartitem->product->price;
        });
        // $totalAmount = $cartitems->getCollection()->sum(function($cartitem) {
        //     return $cartitem->quantity * $cartitem->product->price;
        // });

        return view('cartitems.viewitems', [
            'cartitems' => $cartitems,
            'categories' => $categories,
            'cartid' => $cartid,
            'totalAmount' => $totalAmount
        ]);
    }

    public function search(Request $request, $cartid)
{
    // Get the search inputs from the request
    $category = $request->input('cartitemtype', 'all');
    $item = $request->input('q', 'all');

    $usercartitems = CartItems::with('product')->where('cart_id', $cartid)->get();

    // Start building the query for the user's cart items
    $searchQuery = CartItems::with('product')->where('cart_id', $cartid);

    // Filter by category if a category is specified and it's not 'all'
    if ($category && $category !== 'all') {
        $searchQuery->whereHas('product', function($query) use ($category) {
            $query->where('category_id', $category);
        });
    }

    // Filter by item name if a search term is specified and it's not 'all'
    if ($item && $item !== 'all') {
        $searchQuery->whereHas('product', function($query) use ($item) {
            $query->where('name', 'like', '%' . $item . '%');
        });
    }

    // Execute the search query and paginate the results
    $cartitems = $searchQuery->paginate(5)->appends(['cartitemtype' => $category, 'q' => $item]);

    // Retrieve all categories for the dropdown filter
    $categories = Categories::all();

    // Calculate the total amount for the filtered cart items
    $totalAmount = $usercartitems->sum(function ($cartitem) {
        return $cartitem->quantity * $cartitem->product->price;
    });

    // Return the view with the filtered cart items, categories, cart ID, and total amount
    return view('cartitems.viewitems', [
        'cartitems' => $cartitems,
        'categories' => $categories,
        'cartid' => $cartid,
        'totalAmount' => $totalAmount
    ]);
}


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CartItems $cartItems)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCartItemsRequest $request, CartItems $cartItems)
    {

        $validatedData = $request->validated();

        // Verify that the product information has not been tampered with
        $product = Products::find($cartItems->product_id);
        if ($request->input('product_id') != $product->id) {
            return redirect()->back()->with('error', 'Product details are incorrect.');
        }

        // Update the cart item
        $cartItems->quantity = $validatedData['quantity'];
        $cartItems->save();

        return redirect()->back()->with('success', 'Cart item updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CartItems $cartItems)
    {

        $action = $cartItems->deleteOrFail();

        if ($action) {

            return  back()->with('success', 'item removed');
        } else {
            return back()->with('error', 'failed to remove item');
        }
    }
}
