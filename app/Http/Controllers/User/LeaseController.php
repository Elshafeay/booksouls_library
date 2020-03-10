<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;

use App\Lease;
use Illuminate\Http\Request;
use Auth;


class LeaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $lease = new Lease;
        $lease->user_id = Auth::id();
        $lease->book_id = $request->book;
        $lease->duration = 10;
        $lease->save();
        return redirect('books')->with('success','You have booked this book successfully, Now you can come to our place to get it!');;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Lease  $lease
     * @return \Illuminate\Http\Response
     */
    public function show(Lease $lease)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Lease  $lease
     * @return \Illuminate\Http\Response
     */
    public function edit(Lease $lease)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Lease  $lease
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lease $lease)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Lease  $lease
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lease $lease)
    {
        //
    }

    public function removeLease(Request $request){
        Lease::where([
                    ["user_id", Auth::id()],
                    ["book_id", $request->book],
                ])->delete();
        return redirect('books')->with('success', 'We hope that you had fun with the book, please take a moment of your time to review the book!');;
    
    }
}
