<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRegisterUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterUserController extends Controller
{
    public function create(){
        return view('auth.register');
    }

    public function store(StoreRegisterUserRequest $request){
        $validatedData= $request->validated();

        $user=User::create($validatedData);


        if(!Auth::check()){
            $request->session()->regenerate();
            Auth::login($user);
        }

        return redirect('/dashboard')->with('success','Registration success-login successful');



    }
}
