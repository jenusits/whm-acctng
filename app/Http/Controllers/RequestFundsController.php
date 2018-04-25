<?php

namespace App\Http\Controllers;

use App\Request_funds;
use Illuminate\Http\Request;

class RequestFundsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('request_funds.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('request_funds.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Request_funds  $request_funds
     * @return \Illuminate\Http\Response
     */
    public function show(Request_funds $request_funds)
    {
        //
        return view('request_funds.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Request_funds  $request_funds
     * @return \Illuminate\Http\Response
     */
    public function edit(Request_funds $request_funds)
    {
        //
        return view('request_funds.create');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Request_funds  $request_funds
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Request_funds $request_funds)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Request_funds  $request_funds
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request_funds $request_funds)
    {
        //
    }
}
