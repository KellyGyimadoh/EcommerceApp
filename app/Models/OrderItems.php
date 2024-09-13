<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItems extends Model
{
    use HasFactory;
    public function orders(){
        return $this->belongsTo(Orders::class,'order_id');
    }

    public function products(){
        return $this->belongsTo(Products::class,'products_id');
    }
}
