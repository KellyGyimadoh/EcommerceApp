<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;
    public function category(){
        return $this->belongsTo(Categories::class);
    }

    public function status(){
        return $this->status;
    }
    public function orderitems(){
        return $this->hasMany(OrderItems::class,'products_id');
    }

    public function cartitems(){
        return $this->hasMany(CartItems::class);
    }
}
