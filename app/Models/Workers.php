<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workers extends Model
{
    use HasFactory;
    protected function casts(){
        return[
            'password'=>'hashed',
            'email_verified_at'=>'datetime'
        ];
    }
    protected $hidden=[
        'password'
    ];
}
