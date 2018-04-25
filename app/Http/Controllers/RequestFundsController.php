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
        $request_funds = Request_funds::orderby('id','asc')->get();
        return view('request_funds.index', compact('request_funds'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $categories = \App\Charts::all();
        return view('request_funds.create', compact('categories'));
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
        return redirect()->back();
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
        $categories = \App\Charts::all();
        return view('request_funds.edit', compact('categories'));
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
        return redirect()->back();
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
        return redirect()->back();
    }
}
