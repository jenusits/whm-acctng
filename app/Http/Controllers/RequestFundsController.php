<?php

namespace App\Http\Controllers;

use App\Request_funds;
use App\Charts;
use Illuminate\Http\Request;

use Auth;


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
        $charts = new Charts;
        // dd($request_funds);
        return view('request_funds.index', compact('request_funds', 'charts'));
        // return view('request_funds.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $categories = Charts::all();
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

        $this->validate($request,[
            'particulars' => 'required',
            'amount' => 'required',
            'category' => 'required'
        ]);

        $rf = new Request_funds;
        
        $rf->particulars = request('particulars');
        $rf->amount = request('amount');
        $rf->category = request('category');

        $rf->author = Auth::id();

        $rf->save();
        session()->flash('message', 'Request submitted successfully');
        // Request_funds::create(request(['particulars', 'amount', 'category']));
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
