<?php

namespace App\Observers;

use App\Models\Products;
use Carbon\Carbon;

class ProductsExpiryObserver
{
    /**
     * Handle the Products "created" event.
     */
    public function created(Products $products): void
    {

    }

    /**
     * Handle the Products "updated" event.
     */
    public function updated(Products $products): void
    {
        $allproducts=Products::all();

        $currentdate=Carbon::now();
        foreach($allproducts as $product){
            if ($product->expiry_date <= $currentdate && $product->status === 0) {
                // Update the product status
                $product->status = 1;
                $product->save(); // Save the changes to the database
            }
        }
    }

    /**
     * Handle the Products "deleted" event.
     */
    public function deleted(Products $products): void
    {
        //
    }

    /**
     * Handle the Products "restored" event.
     */
    public function restored(Products $products): void
    {
        //
    }

    /**
     * Handle the Products "force deleted" event.
     */
    public function forceDeleted(Products $products): void
    {
        //
    }
}
