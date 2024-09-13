<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesMail extends Model
{
    use HasFactory;
    protected $table='sales_mails';
    public function user(){
        return $this->belongsTo(User::class);
    }
}
