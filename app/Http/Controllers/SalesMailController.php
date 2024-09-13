<?php

namespace App\Http\Controllers;

use App\Jobs\SalesMailJob;
use App\Models\SalesMail;
use App\Models\User;
use Illuminate\Http\Request;

class SalesMailController extends Controller
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
    public function store(Request $request,User $user)
    {
        $validatedMail= $request->validate([
            'recipient'=>['required','email'],
            'body'=>['required'],
            'subject'=>['required'],

        ]);

        $salesmail=SalesMail::create(attributes: array_merge($validatedMail,['user_id'=>$user->id]));

        dispatch(new SalesMailJob($salesmail));

        return back()->with('success','Mail sent ');

    }

    /**
     * Display the specified resource.
     */
    public function show(SalesMail $salesMail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SalesMail $salesMail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SalesMail $salesMail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SalesMail $salesMail)
    {
        //
    }
}
