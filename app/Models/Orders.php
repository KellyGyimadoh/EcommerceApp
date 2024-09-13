<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;

    public function orderitems(){
        return $this->hasMany(OrderItems::class,'order_id');
    }
    public function payments(){
        return $this->hasOne(Payments::class,'order_id');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
